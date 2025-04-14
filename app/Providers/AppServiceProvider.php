<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        // For MySQL databases using utf8mb4 collation
        Schema::defaultStringLength(191);  // Set the string length limit for indexes to 191 characters

        // Force HTTPS in production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
