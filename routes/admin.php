<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ExternalLabController;
use App\Http\Controllers\Admin\LabController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

// all middlewares, prefixes and suffixes are in routeserviceprovider
//Route::get('admin/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');


//Doctors section Routes
Route::put('doctors/{id}/updatePassword', [DoctorController::class, 'updatePassword'])->name('doctors.updatePassword');
Route::resource('doctors', DoctorController::class);

//Labs section Routes
Route::resource('labs', LabController::class);

//External Labs section Routes
Route::resource('external_labs', ExternalLabController::class);
