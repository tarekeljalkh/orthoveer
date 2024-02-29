<?php

use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Lab\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lab Routes
|--------------------------------------------------------------------------
|
*/
// all middlewares, prefixes and suffixes are in routeserviceprovider
//Route::get('lab/dashboard', [LabController::class, 'index'])->middleware(['auth', 'role:lab'])->name('lab.dashboard');

Route::get('dashboard', [LabController::class, 'index'])->name('dashboard');

//Orders Routes
Route::resource('orders', OrderController::class);
