<?php

use RedRockDigital\Api\Http\Controllers\Billing\{
    IntentController,
    InvoiceController,
    PaymentMethodController,
    SubscriptionController
};
use RedRockDigital\Api\Http\Controllers\Me\{
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
use RedRockDigital\Api\Http\Controllers\Password\{
    PasswordResetController,
    PasswordResetLinkController
};
use RedRockDigital\Api\Http\Controllers\Team\{
    OnboardedController,
    TeamController,
    UserController,
};
use RedRockDigital\Api\Http\Controllers\{
    Blog\BlogController,
    Contact\ContactController,
    Newsletter\SubscribeController,
    RegisterController,
    VerifyEmailController,
    WebHookController
};
use RedRockDigital\Api\Http\Middleware\TwoFactorVerified;
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

Route::post('upload', [SignedStorageUrlController::class, 'store']);

Route::as('me.')->prefix('me')->group(function () {
    Route::get('', [MeController::class, 'show'])
        ->name('show')
        ->withoutMiddleware(TwoFactorVerified::class)
        ->withoutMiddleware('verified');

    Route::patch('', [MeController::class, 'update'])->name('update');
    Route::patch('password', [PasswordController::class, 'update'])->name('update.password');

    Route::patch('team', [MeTeamController::class, 'update'])->name('update.team');

    Route::apiResource(
        'tokens',
        TokenController::class
    )->only(['index', 'store', 'destroy']);

    Route::apiResource(
        'notifications',
        NotificationController::class
    )->only(['index', 'update']);

    Route::prefix('two-factor')->group(function () {
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
    Route::prefix('informable')->group(function () {
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
