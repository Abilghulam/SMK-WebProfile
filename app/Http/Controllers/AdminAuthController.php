<?php

namespace App\Http\Controllers;

use App\Mail\AdminOtpMail;
use App\Models\AdminOtp;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    // Konfigurasi hardening (bisa kamu pindah ke config kalau mau)
    private int $loginMaxAttempts = 5;
    private int $loginDecaySeconds = 60;

    private int $otpTtlMinutes = 3;
    private int $otpMaxAttempts = 5;         // salah OTP berapa kali
    private int $otpLockMinutes = 10;        // lock sementara setelah max attempts
    private int $otpResendCooldownSeconds = 60; // minimal jarak resend
    private int $otpSendMaxPerHour = 6;      // batasi spam email OTP

    // Kalau true, OTP hanya valid untuk IP saat OTP dikirim (lebih aman untuk admin)
    private bool $bindOtpToIp = true;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        // Rate limit login (anti brute force)
        $key = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, $this->loginMaxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."])
                ->withInput();
        }

        if (!Auth::attempt($request->only('email','password'))) {
            RateLimiter::hit($key, $this->loginDecaySeconds);
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        // Login sukses → regenerate session (anti session fixation)
        $request->session()->regenerate();
        RateLimiter::clear($key);

        // Pastikan status OTP di sesi selalu reset ketika login
        $request->session()->put('admin_otp_verified', false);

        $user = Auth::user();

        // Bersihkan OTP lama user agar tidak numpuk
        AdminOtp::where('user_id', $user->id)->delete();

        // Kirim OTP pertama
        $this->issueOtpForUser($user->id, $request->ip());

        return redirect()->route('admin.otp.form');
    }

    public function showOtpForm(Request $request)
    {
        if (!Auth::check()) return redirect()->route('admin.login');

        if ($request->session()->get('admin_otp_verified') === true) {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        $otp = AdminOtp::where('user_id', $user->id)->latest()->first();

        $cooldownSeconds = $this->otpResendCooldownSeconds; // pakai config controller
        $cooldownRemaining = 0;

        if ($otp && $otp->sent_at) {
            $nextAllowed = $otp->sent_at->copy()->addSeconds($cooldownSeconds);
            $cooldownRemaining = now()->lt($nextAllowed) ? now()->diffInSeconds($nextAllowed) : 0;
        }

        $expiresAtIso = $otp && $otp->expires_at ? $otp->expires_at->toIso8601String() : null;

        return view('auth.otp', compact('cooldownRemaining', 'expiresAtIso'));
    }

    public function verifyOtp(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // IMPORTANT: name input harus "otp" (sesuai view kamu)
        $request->validate([
            'otp' => ['required','digits:6'],
        ]);

        $user = Auth::user();

        /** @var AdminOtp|null $otp */
        $otp = AdminOtp::where('user_id', $user->id)->latest()->first();

        if (!$otp) {
            return redirect()->route('admin.login')->withErrors([
                'otp' => 'Sesi OTP tidak ditemukan. Silakan login ulang.',
            ]);
        }

        // Lock sementara
        if (!empty($otp->locked_until) && now()->lt($otp->locked_until)) {
            $remaining = now()->diffInSeconds($otp->locked_until);
            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Coba lagi dalam {$remaining} detik atau login ulang.",
            ]);
        }

        // Expired
        if (!empty($otp->expires_at) && now()->greaterThan($otp->expires_at)) {
            return redirect()->route('admin.login')->withErrors([
                'otp' => 'Kode sudah kedaluwarsa. Silakan login ulang.',
            ]);
        }

        // Bind IP (opsional tapi disarankan untuk admin)
        if ($this->bindOtpToIp && !empty($otp->last_sent_ip) && $otp->last_sent_ip !== $request->ip()) {
            return redirect()->route('admin.login')->withErrors([
                'otp' => 'Perangkat/IP berubah. Demi keamanan, silakan login ulang.',
            ]);
        }

        // Cek attempt
        if ((int) $otp->attempts >= $this->otpMaxAttempts) {
            // set lock
            $otp->locked_until = now()->addMinutes($this->otpLockMinutes);
            $otp->save();

            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Akun dikunci sementara {$this->otpLockMinutes} menit.",
            ]);
        }

        // Naikkan attempt dulu (biar brute-force nggak bisa “free retry” saat error)
        $otp->increment('attempts');

        // Validasi OTP
        if (!Hash::check($request->otp, $otp->code_hash)) {
            // Kalau setelah increment mencapai batas, lock sekarang juga
            if ((int) $otp->attempts >= $this->otpMaxAttempts) {
                $otp->locked_until = now()->addMinutes($this->otpLockMinutes);
                $otp->save();
                return back()->withErrors([
                    'otp' => "Kode salah. Akun dikunci sementara {$this->otpLockMinutes} menit.",
                ]);
            }

            return back()->withErrors([
                'otp' => 'Kode verifikasi salah.',
            ]);
        }

        // Sukses → tandai session verified
        $request->session()->put('admin_otp_verified', true);

        // Optional: regenerate session lagi setelah OTP sukses (lebih aman)
        $request->session()->regenerate();

        // Hapus OTP agar tidak bisa dipakai ulang
        $otp->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Verifikasi berhasil.');
    }

    /**
     * Resend OTP (pastikan kamu punya route untuk ini kalau mau dipakai)
     */
    public function resendOtp(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        $otp = AdminOtp::where('user_id', $user->id)->latest()->first();
        if (!$otp) {
            return redirect()->route('admin.login')->with('error', 'Sesi OTP tidak ditemukan. Silakan login ulang.');
        }

        // Cooldown resend
        if (!empty($otp->sent_at)) {
            $nextAllowed = $otp->sent_at->copy()->addSeconds($this->otpResendCooldownSeconds);
            if (now()->lt($nextAllowed)) {
                $remaining = now()->diffInSeconds($nextAllowed);
                return back()->with('error', "Tunggu {$remaining} detik sebelum kirim ulang OTP.");
            }
        }

        // Limit kirim OTP per jam (anti spam)
        $rateKey = 'admin-otp-send:'.$user->id;
        if (RateLimiter::tooManyAttempts($rateKey, $this->otpSendMaxPerHour)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return back()->with('error', "Terlalu sering meminta OTP. Coba lagi dalam {$seconds} detik.");
        }
        RateLimiter::hit($rateKey, 3600);

        // Invalidate OTP lama & kirim baru
        AdminOtp::where('user_id', $user->id)->delete();
        $this->issueOtpForUser($user->id, $request->ip());

        return back()->with('success', 'OTP baru telah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Generate + simpan OTP (hash) + kirim email
     */
    private function issueOtpForUser(int $userId, string $ip): void
    {
        $code = (string) random_int(100000, 999999);

        AdminOtp::create([
            'user_id'      => $userId,
            'code_hash'    => Hash::make($code),
            'expires_at'   => now()->addMinutes($this->otpTtlMinutes),
            'attempts'     => 0,
            'locked_until' => null,
            'last_sent_ip' => $ip,
            'sent_at'      => now(),
        ]);

        $siteName = optional(Setting::first())->site_name ?? config('app.name');

        // Kirim email OTP
        $userEmail = Auth::user()?->email; // aman karena dipanggil setelah login
        if ($userEmail) {
            Mail::to($userEmail)->send(new AdminOtpMail($code, $siteName, $this->otpTtlMinutes));
        }
    }
}
