<?php

use App\Http\Controllers\SuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
|
*/
// all middlewares, prefixes and suffixes are in routeserviceprovider
//Route::get('super_admin/dashboard', [SuperAdminController::class, 'index'])->middleware(['auth', 'role:super_admin'])->name('super_admin.dashboard');

Route::get('dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
