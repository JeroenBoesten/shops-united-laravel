<?php

namespace JeroenOnline\ShopsUnitedLaravel;

use Illuminate\Support\ServiceProvider;

class ShopsUnitedLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('shops-united-laravel.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'shops-united-laravel');

        // Register the main class to use with the facade
        $this->app->singleton('shops-united-laravel', function () {
            return new ShopsUnitedLaravel;
        });
    }
}
