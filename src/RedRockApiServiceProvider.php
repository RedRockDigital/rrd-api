<?php

namespace RedRockDigital\Api;

use RedRockDigital\Api\Console\Commands\InstallCommand;
use RedRockDigital\Api\Console\Commands\PruneLogs;
use RedRockDigital\Api\Console\Commands\SendRegistrationReminders;
use RedRockDigital\Api\Console\Commands\SetupCommand;
use RedRockDigital\Api\Models\Group;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class RedRockApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
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

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

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
                SetupCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        
    }
}
