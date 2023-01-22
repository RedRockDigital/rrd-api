<?php

use Illuminate\Support\Facades\Route;

Route::view('/{path?}', 'app')
    ->where('path', '^(?:(?!\/api\/).)*$')
    ->name('react');

include dirname(__FILE__).'/frontend-routes.php';
