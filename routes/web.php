<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectionController;

Route::get('/', function () {
    return view('welcome');
});

// Create route must come before the dynamic {id} route
Route::get('/polling-units/create', [ElectionController::class, 'createPollingUnit'])
    ->name('polling-units.create');

Route::post('/polling-units', [ElectionController::class, 'storePollingUnit'])
    ->name('polling-units.store');

Route::get('/polling-units/{id}', [ElectionController::class, 'showPollingUnit'])
    ->whereNumber('id')
    ->name('polling-units.show');

Route::get('/lga-results', [ElectionController::class, 'lgaResults'])
    ->name('lga-results');
