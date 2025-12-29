<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Harus login
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Harus punya role admin/super_admin
        if (!in_array($user->role, ['super_admin', 'admin'], true)) {
            abort(403, 'Anda tidak memiliki akses admin.');
        }

        return $next($request);
    }
}
