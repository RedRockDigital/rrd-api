<?php

namespace RedRockDigital\Api;

use Illuminate\Support\Str;
use RedRockDigital\Api\Console\Commands\InstallCommand;
use RedRockDigital\Api\Console\Commands\PruneLogs;
use RedRockDigital\Api\Console\Commands\SendRegistrationReminders;
use RedRockDigital\Api\Console\Commands\SetupCommand;
use RedRockDigital\Api\Database\Seeders\Local\LocalSeeder;
use RedRockDigital\Api\Models\Group;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories;

class RedRockApiServiceProvider extends ServiceProvider
{
    /**
     * The namespace for the factories.
     *
     * @var string
     */
    public static string $factoryNamespace = 'RedRockDigital\\Database\\Factories\\';

    /**
     * The namespace for the models.
     *
     * @var string
     */
    public static string $modelNamespace = 'RedRockDigital\\Api\\Models\\';

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Load the routes
        $this->loadRoutes();

        // Load the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load the variables for the application
        $this->loadVariables();

        // Load the factories
        $this->loadFactories();

        // Load the console commands
        $this->loadConsole();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        
    }

    /**
     * Load the routes for the application.
     *
     * @return void
     */
    private function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Boot the variables for the application.
     *
     * @return void
     */
    private function loadVariables(): void
    {
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $url = request()->filled('url') ? request()->get('url') : config('app.url') . 'verify/';
            $token = hash_hmac('sha256', $notifiable->getKey(), sha1($notifiable->getEmailForVerification()));

            return $url . $notifiable->getKey() . '/' . $token;
        });

        View::composer('app', function ($view) {
            $view->with('app', [
                'groups'        => Group::all(),
                'feature_flags' => config('feature-flags'),
                'tiers'         => config('payments.stripe.tiers'),
            ]);
        });
    }

    /**
     * Load the factories for the application.
     *
     * @return void
     */
    private function loadFactories()
    {
        Factories\Factory::guessFactoryNamesUsing(function (string $modelName) {
            return self::$factoryNamespace . class_basename($modelName) . 'Factory';
        });

        Factories\Factory::guessModelNamesUsing(function ($factory) {
            return self::$modelNamespace . Str::replaceLast('Factory', '', class_basename($factory));
        });
    }

    /**
     * Load the console commands for the application.
     *
     * @return void]
     */
    private function loadConsole()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/base.php'     => config_path('base.php'),
                __DIR__ . '/../config/payments.php' => config_path('payments.php'),
                __DIR__ . '/../config/auth.php'     => config_path('auth.php')
            ]);

            // Registering package commands.
            $this->commands([
                InstallCommand::class,
                PruneLogs::class,
                SendRegistrationReminders::class,
                SetupCommand::class,
            ]);
        }
    }
}
