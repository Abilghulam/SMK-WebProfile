<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            // kalau akses admin, arahkan ke login admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // selain admin, arahkan ke homepage (karena tidak ada login user)
            return url('/');
        }

        return null;
    }
}
