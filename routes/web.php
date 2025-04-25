<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\BudidayaController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::resource('commodity', KomoditasController::class);
Route::resource('budidaya', BudidayaController::class);

Route::get('/', [LocationController::class, 'showLocations']);