<?php

namespace RedRockDigital\Api\Providers;

use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use RedRockDigital\Api\Http\Middleware\Authenticate;
use RedRockDigital\Api\Http\Middleware\Suspended;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['auth:api', EnsureEmailIsVerified::class, Suspended::class])
                ->prefix('api')
                ->group(__DIR__ . '/../../routes/api.php');

            Route::prefix('api')
                ->group(__DIR__ . '/../../routes/dmz.php');

            Route::middleware('web')
                ->group(__DIR__ . '/../../routes/web.php');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(config('app.debug') ? 12000 : 120)->by($request->user()?->id ?: $request->ip());
        });
    }
}
