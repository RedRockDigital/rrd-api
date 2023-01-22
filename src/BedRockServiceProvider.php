<?php

namespace RedRockDigital\BedRock;

use Illuminate\Support\ServiceProvider;
use RedRockDigital\Api\Console\Commands\{InstallCommand, PruneLogs, SendRegistrationReminders, SetupCommand};

class BedRockServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bedrock');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bedrock');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('bedrock.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/bedrock'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/bedrock'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/bedrock'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([
                 InstallCommand::class,
                 PruneLogs::class,
                 SendRegistrationReminders::class,
                 SetupCommand::class,
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'bedrock');

        // Register the main class to use with the facade
        $this->app->singleton('bedrock', function () {
            return new BedRock;
        });
    }
}
