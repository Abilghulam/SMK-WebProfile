<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureAdminOtpVerified;
use App\Http\Middleware\AdminAccess;
use App\Http\Middleware\SuperAdminOnly;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
        ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.otp'    => EnsureAdminOtpVerified::class,
            'admin.access' => AdminAccess::class,
            'super_admin' => SuperAdminOnly::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
