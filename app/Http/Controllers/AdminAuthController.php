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
    private int $loginMaxAttempts = 5;
    private int $loginDecaySeconds = 60;

    private int $otpTtlMinutes = 3;
    private int $otpMaxAttempts = 5;        
    private int $otpLockMinutes = 10;       
    private int $otpResendCooldownSeconds = 60;
    private int $otpSendMaxPerHour = 6;     

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

       
        $request->session()->regenerate();
        RateLimiter::clear($key);

       
        $request->session()->put('admin_otp_verified', false);

        $user = Auth::user();

       
        AdminOtp::where('user_id', $user->id)->delete();

       
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

      
        if (!empty($otp->locked_until) && now()->lt($otp->locked_until)) {
            $remaining = now()->diffInSeconds($otp->locked_until);
            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Coba lagi dalam {$remaining} detik atau login ulang.",
            ]);
        }

       
        if (!empty($otp->expires_at) && now()->greaterThan($otp->expires_at)) {
            return redirect()->route('admin.login')->withErrors([
                'otp' => 'Kode sudah kedaluwarsa. Silakan login ulang.',
            ]);
        }

       
        if ($this->bindOtpToIp && !empty($otp->last_sent_ip) && $otp->last_sent_ip !== $request->ip()) {
            return redirect()->route('admin.login')->withErrors([
                'otp' => 'Perangkat/IP berubah. Demi keamanan, silakan login ulang.',
            ]);
        }

      
        if ((int) $otp->attempts >= $this->otpMaxAttempts) {
            
            $otp->locked_until = now()->addMinutes($this->otpLockMinutes);
            $otp->save();

            return back()->withErrors([
                'otp' => "Terlalu banyak percobaan. Akun dikunci sementara {$this->otpLockMinutes} menit.",
            ]);
        }

      
        $otp->increment('attempts');

        if (!Hash::check($request->otp, $otp->code_hash)) {
           
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

        $request->session()->put('admin_otp_verified', true);

        $request->session()->regenerate();

        $otp->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Verifikasi berhasil.');
    }

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

        if (!empty($otp->sent_at)) {
            $nextAllowed = $otp->sent_at->copy()->addSeconds($this->otpResendCooldownSeconds);
            if (now()->lt($nextAllowed)) {
                $remaining = now()->diffInSeconds($nextAllowed);
                return back()->with('error', "Tunggu {$remaining} detik sebelum kirim ulang OTP.");
            }
        }

        $rateKey = 'admin-otp-send:'.$user->id;
        if (RateLimiter::tooManyAttempts($rateKey, $this->otpSendMaxPerHour)) {
            $seconds = RateLimiter::availableIn($rateKey);
            return back()->with('error', "Terlalu sering meminta OTP. Coba lagi dalam {$seconds} detik.");
        }
        RateLimiter::hit($rateKey, 3600);

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

        $userEmail = Auth::user()?->email; 
        if ($userEmail) {
            Mail::to($userEmail)->send(new AdminOtpMail($code, $siteName, $this->otpTtlMinutes));
        }
    }
}
