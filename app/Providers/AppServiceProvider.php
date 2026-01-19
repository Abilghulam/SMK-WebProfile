<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\SchoolProfile;
use App\Models\Setting;
use Illuminate\Auth\Notifications\ResetPassword;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('id');

        // Jangan query DB saat artisan/composer berjalan
        if (!app()->runningInConsole()) {

            // Share settings hanya jika tabelnya sudah ada
            if (Schema::hasTable('settings')) {
                $settings = Setting::query()->first();
                View::share('settings', $settings);

                View::composer(['layouts.app', 'partials.navbar', 'partials.footer'], function ($view) use ($settings) {
                    $view->with('settings', $settings);
                });
            }

            // Share schoolProfile hanya jika tabelnya sudah ada
            if (Schema::hasTable('school_profiles')) {
                View::composer(['partials.navbar', 'partials.footer'], function ($view) {
                    $view->with('schoolProfile', SchoolProfile::first());
                });
            }
        }

        // Ini aman, tidak query DB
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            return route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
        });
    }
}
