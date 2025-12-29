<?php 

namespace App\Http\Controllers;

use App\Mail\AdminOtpMail;
use App\Models\AdminOtp;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class AdminAuthController extends Controller
{
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

        // Rate limit (anti brute force)
        $key = Str::lower($request->input('email')).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."])
                ->withInput();
        }

        if (!Auth::attempt($request->only('email','password'))) {
            RateLimiter::hit($key, 60);
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        // Login sukses → regenerate session (anti session fixation)
        $request->session()->regenerate();
        RateLimiter::clear($key);

        // Buat OTP & kirim email
        $user = Auth::user();
        $ttlMinutes = 10;
        $plainCode = (string) random_int(100000, 999999);

        if (app()->environment('local')) {
            Log::info('ADMIN OTP GENERATED', [
                'user_id' => $user->id,
                'email' => $user->email,
                'otp' => $plainCode,
                'ttl_minutes' => $ttlMinutes,
            ]);
        }

        AdminOtp::where('user_id', $user->id)->delete(); // bersihkan OTP lama

        AdminOtp::create([
            'user_id'    => $user->id,
            'code_hash'  => Hash::make($plainCode),
            'expires_at' => now()->addMinutes($ttlMinutes),
            'attempts'   => 0,
            'sent_at'    => now(),
        ]);

        $siteName = optional(Setting::first())->site_name ?? config('app.name');

        Mail::to($user->email)->send(new AdminOtpMail($plainCode, $siteName, $ttlMinutes));

        // tandai sesi OTP belum verified
        $request->session()->put('admin_otp_verified', false);

        return redirect()->route('admin.otp.form');
    }

    public function showOtpForm(Request $request)
    {
        // kalau belum login, arahkan ke login
        if (!Auth::check()) return redirect()->route('admin.login');

        // kalau sudah verified, ke dashboard
        if ($request->session()->get('admin_otp_verified') === true) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        if (!Auth::check()) return redirect()->route('admin.login');

        $request->validate([
            'otp' => ['required','digits:6'],
        ]);

        $user = Auth::user();
        $otp = AdminOtp::where('user_id', $user->id)->latest()->first();

        if (!$otp || now()->greaterThan($otp->expires_at)) {
            return back()->withErrors(['otp' => 'Kode sudah kedaluwarsa. Silakan login ulang.']);
        }

        if ($otp->attempts >= 5) {
            return back()->withErrors(['otp' => 'Terlalu banyak percobaan. Silakan login ulang.']);
        }

        $otp->increment('attempts');

        if (!Hash::check($request->otp, $otp->code_hash)) {
            return back()->withErrors(['otp' => 'Kode verifikasi salah.']);
        }

        // sukses
        $request->session()->put('admin_otp_verified', true);

        // optional: hapus OTP setelah berhasil
        $otp->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Verifikasi berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}