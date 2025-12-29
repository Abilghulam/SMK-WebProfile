<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'super_admin') {
            abort(403, 'Khusus Super Admin.');
        }

        return $next($request);
    }
}
