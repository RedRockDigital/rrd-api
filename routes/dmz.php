<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;
use RedRockDigital\Api\Http\Middleware\Webhooks\StripeWebhookMiddleware;
use RedRockDigital\Api\Http\Controllers\{
    Blog\BlogController,
    Contact\ContactController,
    Newsletter\SubscribeController,
    RegisterController,
    VerifyEmailController,
    WebHookController
};
use RedRockDigital\Api\Http\Controllers\Password\{
    PasswordResetController,
    PasswordResetLinkController
};

Route::as('webhooks.')->prefix('webhooks')->group(function () {
    Route::middleware(StripeWebhookMiddleware::class)->group(function () {
        Route::post('/stripe', [WebHookController::class, 'stripe'])->name('stripe');
    });
});

Route::post('register', [RegisterController::class, 'store'])->name('register');
Route::get('verify-email', [VerifyEmailController::class, 'show'])->name('verify-email');
Route::post('verify-email', [VerifyEmailController::class, 'store'])->name('verify-email');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('forgot-password');
Route::patch('reset-password', [PasswordResetController::class, 'update'])->name('reset-password');

Route::post('contact', ContactController::class)->name('contact');

Route::post('newsletter/subscribe', SubscribeController::class)->name('newsletter.subscribe');

Route::apiResource('blogs', BlogController::class)->only(['index', 'show']);