<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Tambahkan line ini di bagian atas
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
        // 2. Tambahkan logika ini untuk memaksa HTTPS saat pakai ngrok
        if (str_contains(request()->header('host'), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }
    }
}