<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        // Set default locale to Indonesian
        app()->setLocale('id');
        // Register Guest Layout Component
        Blade::component('layouts.guest', 'guest-layout');
        
        // Register Other Auth Components
        Blade::component('components.auth-session-status', 'auth-session-status');
        Blade::component('components.auth-validation-errors', 'auth-validation-errors');
        Blade::component('components.input-error', 'input-error');
        Blade::component('components.input-label', 'input-label');
        Blade::component('components.text-input', 'text-input');
        Blade::component('components.primary-button', 'primary-button');
    }
}
