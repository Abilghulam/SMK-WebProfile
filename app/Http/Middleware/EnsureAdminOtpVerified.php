<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminOtpVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->get('admin_otp_verified')) {
            return redirect()->route('admin.otp.form');
        }
        return $next($request);
    }
}
