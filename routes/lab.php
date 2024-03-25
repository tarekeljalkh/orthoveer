<?php

use App\Http\Controllers\Lab\ChatController;
use App\Http\Controllers\Lab\CommentController;
use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Lab\NotificationController;
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
Route::get('orders/new', [OrderController::class, 'new'])->name('orders.new');
Route::get('orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
Route::get('orders/viewer/{id}', [OrderController::class, 'viewer'])->name('orders.viewer');
Route::get('orders/prescription/{id}', [OrderController::class, 'prescription'])->name('orders.prescription');
//reject order
Route::post('orders/reject/{id}', [OrderController::class, 'reject'])->name('orders.reject');
Route::resource('orders', OrderController::class);
/** Download Order */
Route::get('/orders/{order}/download-stl', [OrderController::class, 'downloadStl'])->name('orders.downloadStl');

//Comments Routes
Route::resource('comments', CommentController::class);

/** Order Notification Routes */
Route::get('clear-notification', [LabController::class, 'clearNotification'])->name('clear-notification');

/** chat Routes */
Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

/** Notification Routes */
Route::get('/notifications/seen/{notification}', [NotificationController::class, 'markAsSeen'])->name('notifications.seen');
Route::resource('notifications', NotificationController::class);

