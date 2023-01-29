<?php

use Illuminate\Support\Facades\Route;

Route::view('/{path?}', 'app')
    ->where('path', '^(?:(?!\/nova\/).)*$')
    ->name('react');

include dirname(__FILE__).'/frontend-routes.php';
