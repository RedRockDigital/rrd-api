<?php

use Illuminate\Support\Facades\Route;

Route::get('/verify-account/{id}/{hash}')
    ->name('frontend.verification.verify');

Route::get('/password/reset/{token}')
    ->name('password.reset');
