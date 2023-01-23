<?php

use App\Http\Controllers\Billing\{
    IntentController,
    InvoiceController,
    PaymentMethodController,
    SubscriptionController
};
use App\Http\Controllers\Me\{
    InformController,
    MeController,
    NotificationController,
    PasswordController,
    RecoveryCodeController,
    TeamController as MeTeamController,
    TokenController,
    TwoFactorController,
    TwoFactorQrCodeController,
    VerifyTwoFactorController
};
use App\Http\Controllers\Password\{
    PasswordResetController,
    PasswordResetLinkController
};
use App\Http\Controllers\Team\{
    OnboardedController,
    TeamController,
    UserController,
};
use App\Http\Controllers\{Blog\BlogController,
    Contact\ContactController,
    Newsletter\SubscribeController,
    RegisterController,
    VerifyEmailController,
    WebHookController
};
use App\Http\Middleware\TwoFactorVerified;
use App\Http\Middleware\Webhooks\StripeIdempotencyKeyMiddleware;
use Illuminate\Support\Facades\Route;
use Laravel\Vapor\Http\Controllers\SignedStorageUrlController;

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

Route::middleware(['auth:api', 'verified', 'suspended'])->group(function () {
    Route::post(
        'upload',
        [SignedStorageUrlController::class, 'store']
    );

    Route::as('me.')
        ->prefix('me')
        ->group(function () {
            Route::get('', [MeController::class, 'show'])
                ->name('show')
                ->withoutMiddleware(TwoFactorVerified::class)
                ->withoutMiddleware('verified');

            Route::patch('', [MeController::class, 'update'])->name('update');
            Route::patch('password', [PasswordController::class, 'update'])->name('update.password');

            Route::patch('team', [MeTeamController::class, 'update'])->name('update.team');

            Route::apiResource('tokens', TokenController::class)
                ->only(['index', 'store', 'destroy']);

            Route::apiResource('notifications', NotificationController::class)
                ->only(['index', 'update']);

            Route::prefix('two-factor')
                ->group(function () {
                    Route::post('verify', VerifyTwoFactorController::class)
                        ->name('2fa.verify')
                        ->withoutMiddleware(TwoFactorVerified::class);
                    Route::get('qr-code', [TwoFactorQrCodeController::class, 'show'])->name('2fa.qr-code');

                    Route::post('', [TwoFactorController::class, 'store'])->name('2fa.enable');
                    Route::delete('', [TwoFactorController::class, 'destroy'])->name('2fa.disable');

                    Route::get('recovery-codes', [RecoveryCodeController::class, 'index'])
                        ->name('2fa.get-recovery-codes');
                    Route::post('recovery-codes', [RecoveryCodeController::class, 'store'])
                        ->name('2fa.create-recovery-codes');
                });

            Route::prefix('informable')
                ->group(function () {
                    Route::get('', [InformController::class, 'index'])->name('inform.index');
                    Route::patch('', [InformController::class, 'update'])->name('inform.update');
                });
        });

    Route::prefix('team')
        ->as('team.')
        ->group(function () {
            Route::apiResource('users', UserController::class)
                ->except('show');

            Route::patch('onboarded', OnboardedController::class)
                ->name('onboarded');
        });

    Route::apiResource('team', TeamController::class)
        ->only(['store', 'update']);

    // Subscription
    Route::prefix('billing')
        ->as('billing.')
        ->group(function () {
            Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
            Route::patch('/subscription/change', [SubscriptionController::class, 'change'])->name(
                'subscription.change'
            );
            Route::patch('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name(
                'subscription.cancel'
            );
            Route::patch('/subscription/resume', [SubscriptionController::class, 'resume'])->name(
                'subscription.resume'
            );

            Route::get('/payment-method', [PaymentMethodController::class, 'show'])->name('payment-method.show');
            Route::post('/payment-method', [PaymentMethodController::class, 'store'])->name('payment-method.store');

            Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
            Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
            Route::patch('/invoices', [InvoiceController::class, 'update'])->name('invoices.update');

            Route::post('/intents', [IntentController::class, 'store'])->name('intents.store');
        });
});

Route::as('webhooks.')
    ->prefix('webhooks')
    ->group(function () {
        Route::middleware(StripeIdempotencyKeyMiddleware::class)->group(function () {
            Route::post('/stripe-payment-failed', [WebHookController::class, 'stripe'])->name('stripe.payment_failed');
            Route::post('/stripe-subscription-created', [WebHookController::class, 'stripe'])->name('stripe.subscription_created');
            Route::post('/stripe-subscription-updated', [WebHookController::class, 'stripe'])->name('stripe.subscription_updated');
            Route::post('/stripe-subscription-deleted', [WebHookController::class, 'stripe'])->name('stripe.subscription_deleted');
        });
    });

Route::post('register', [RegisterController::class, 'store'])->name('register');
Route::get('verify-email', [VerifyEmailController::class, 'show'])->name('verify-email');
Route::post('verify-email', [VerifyEmailController::class, 'store'])->name('verify-email');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('forgot-password');
Route::patch('reset-password', [PasswordResetController::class, 'update'])->name('reset-password');

Route::post('contact', ContactController::class)->name('contact');

Route::post('newsletter/subscribe', SubscribeController::class)->name('newsletter.subscribe');

Route::apiResource('blogs', BlogController::class)
    ->only(['index', 'show']);
