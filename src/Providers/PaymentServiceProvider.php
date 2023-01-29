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
        
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('payments', function () {
            return new (config('payments.provider'))();
        });
    }
}
