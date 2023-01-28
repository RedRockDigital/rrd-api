<?php

namespace RedRockDigital\Api;

use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Passport\Passport;
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
use RedRockDigital\Api\Providers\AuthServiceProvider;
use RedRockDigital\Api\Providers\EventServiceProvider;
use RedRockDigital\Api\Providers\NovaServiceProvider;
use RedRockDigital\Api\Providers\PaymentServiceProvider;
use RedRockDigital\Api\Providers\RouteServiceProvider;
use RedRockDigital\Api\Services\Payments\Payments;

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
        // Load the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load the variables for the application
        $this->loadVariables();

        // Load the console commands
        $this->loadConsole();

        // Load the factories
        $this->loadFactories();

        // Load passport configuation
        $this->app->register(AuthServiceProvider::class);

        // Load the Event Listeners
        $this->app->register(EventServiceProvider::class);

        // Load the payments service provider
        $this->app->register(PaymentServiceProvider::class);

        // Load Nova Service Provider
        $this->app->register(NovaServiceProvider::class);

        // Load Route Service Provider
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Temporary fix to remove Cashire Migration
        // TODO: Move payment service into contained repo.
        Cashier::ignoreMigrations();
        
        $this->mergeConfigFrom(__DIR__ . '/../config/auth-guards.php', 'auth.guards');

        $this->mergeConfigFrom(__DIR__ . '/../config/auth-providers.php', 'auth.providers');
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
