<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [LocationController::class, 'showLocations']);