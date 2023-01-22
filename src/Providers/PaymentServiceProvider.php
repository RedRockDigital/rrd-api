<?php

namespace RedRockDigital\Api\Providers;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Laravel\Cashier\Cashier;

/**
 * Class PaymentServiceProvider
 */
class PaymentServiceProvider extends BaseProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/payments.php' => config_path('payments.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        Cashier::ignoreMigrations();

        $this->app->bind('payments', function () {
            return new (config('payments.provider'))();
        });
    }
}
