<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login, paksa ke login
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Jika belum OTP verified, paksa ke form OTP
        if ($request->session()->get('admin_otp_verified') !== true) {
            return redirect()->route('admin.otp.form');
        }

        return $next($request);
    }
}
