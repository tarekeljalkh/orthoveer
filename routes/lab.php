<?php

use App\Http\Controllers\Lab\ChatController;
use App\Http\Controllers\Lab\CommentController;
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
Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
Route::get('orders/viewer/{id}', [OrderController::class, 'viewer'])->name('orders.viewer');
Route::get('orders/prescription/{id}', [OrderController::class, 'prescription'])->name('orders.prescription');
Route::resource('orders', OrderController::class);

//Comments Routes
Route::resource('comments', CommentController::class);

/** chat Routes */
Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
