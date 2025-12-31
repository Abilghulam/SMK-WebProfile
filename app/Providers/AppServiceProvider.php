<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SchoolProfile;
use App\Models\Setting;
use Illuminate\Auth\Notifications\ResetPassword;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        View::share('settings', Setting::query()->first());

        View::composer(['partials.navbar', 'partials.footer'], function ($view) {
            $view->with('schoolProfile', SchoolProfile::first());
        });

        View::composer(['layouts.app', 'partials.navbar', 'partials.footer'], function ($view) {
            $view->with('settings', Setting::first());
        });

                ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
        });

    }
}
