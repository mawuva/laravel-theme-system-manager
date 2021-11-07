<?php

namespace Mawuekom\Systhemer;

use Illuminate\Support\ServiceProvider;
use Mawuekom\Systhemer\Commands\MakeThemeCommand;
use Mawuekom\Systhemer\Theme\Theme;

class SysthemerServiceProvider extends ServiceProvider
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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'systhemer');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'systhemer');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/systhemer.php' => config_path('systhemer.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/systhemer'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/systhemer'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/systhemer'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                MakeThemeCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/systhemer.php', 'systhemer');

        // Register the main class to use with the facade
        $this->app->singleton('systhemer', function () {
            return new Systhemer;
        });
    }
}
