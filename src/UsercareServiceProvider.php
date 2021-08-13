<?php

namespace Mawuekom\Usercare;

use Illuminate\Support\ServiceProvider;

class UsercareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        require_once __DIR__.'/helpers.php';

        /*
         * Optional methods to load your package assets
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'usercare');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/usercare.php' => config_path('usercare.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/usercare.php', 'usercare');

        // Register the main class to use with the facade
        $this->app->singleton('usercare', function () {
            return new Usercare;
        });
    }
}
