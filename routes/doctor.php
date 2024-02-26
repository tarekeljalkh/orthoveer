<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\OrderController;
use App\Http\Controllers\Doctor\PatientController;
use App\Http\Controllers\Doctor\ScanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
|
*/
// all middlewares, prefixes and suffixes are in routeserviceprovider
//Route::get('doctor/dashboard', [DoctorController::class, 'index'])->middleware(['auth', 'role:doctor'])->name('doctor.dashboard');

Route::get('dashboard', [DoctorController::class, 'index'])->name('dashboard');
Route::resource('scans', ScanController::class);
Route::resource('patients', PatientController::class);
Route::resource('orders', OrderController::class);
//Route::get('messages', [SampleController::class, 'total'])->name('sample.total');
