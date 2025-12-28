<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SchoolProfile;
use App\Models\Setting;

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
        View::composer(['partials.navbar', 'partials.footer'], function ($view) {
            $view->with('schoolProfile', SchoolProfile::first());
        });

        View::composer(['layouts.app', 'partials.navbar', 'partials.footer'], function ($view) {
            $view->with('settings', Setting::first());
        });

    }
}
