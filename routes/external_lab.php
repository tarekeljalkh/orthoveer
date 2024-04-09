<?php

use App\Http\Controllers\ExternalLab\ExternalLabController;
use App\Http\Controllers\ExternalLab\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| External_lab Routes
|--------------------------------------------------------------------------
|
*/
// all middlewares, prefixes and suffixes are in routeserviceprovider
//Route::get('external_lab/dashboard', [ExternalLabController::class, 'index'])->middleware(['auth', 'role:external_lab'])->name('external_lab.dashboard');


Route::get('dashboard', [ExternalLabController::class, 'index'])->name('dashboard');


/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
