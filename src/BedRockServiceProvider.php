<?php

namespace RedRockDigital\Api;

use App\Models\Group;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use RedRockDigital\Api\Console\Commands\{InstallCommand, PruneLogs, SendRegistrationReminders, SetupCommand};

class RedRockApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $url = request()->filled('url') ? request()->get('url') : config('app.url').'verify/';
            $token = hash_hmac('sha256', $notifiable->getKey(), sha1($notifiable->getEmailForVerification()));

            return $url.$notifiable->getKey().'/'.$token;
        });

        View::composer('app', function ($view) {
            $view->with('app', [
                'groups'        => Group::all(),
                'feature_flags' => config('feature-flags'),
                'tiers'         => config('payments.stripe.tiers'),
            ]);
        });

         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/routes.php');

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

    }
}
