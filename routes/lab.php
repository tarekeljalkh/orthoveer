<?php

use App\Http\Controllers\Lab\ChatController;
use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Lab\NotificationController;
use App\Http\Controllers\Lab\OrderController;
use App\Http\Controllers\Lab\ScanController;
use App\Http\Controllers\Lab\ProfileController;
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

//Scans Routes
Route::get('scans/new', [ScanController::class, 'new'])->name('scans.new');
Route::get('scans/pending', [ScanController::class, 'pending'])->name('scans.pending');
Route::get('scans/viewer/{id}', [ScanController::class, 'viewer'])->name('scans.viewer');
Route::get('scans/prescription/{id}', [ScanController::class, 'prescription'])->name('scans.prescription');
//reject Scan
Route::post('scans/{id}/update-status', [ScanController::class, 'updateStatus'])->name('scans.updateStatus');
//Complete Scan
Route::post('scans/{id}/complete', [Scancontroller::class, 'complete'])->name('scans.complete');
//Reassign Scan to another Lab
Route::post('/scans/{scan}/reassign', [Scancontroller::class, 'reassignScan'])->name('scans.reassign');

Route::resource('scans', ScanController::class);
/** Download Scan */
Route::get('/scans/{scan}/download-stl', [ScanController::class, 'downloadStl'])->name('scans.downloadStl');
Route::post('/scans/downloadMultiple', [ScanController::class, 'downloadMultiple'])->name('scans.downloadMultiple');
/** Print Scan */
Route::get('/scans/{scanId}/printScan', [ScanController::class, 'printScan'])->name('scans.printScan');
Route::post('/scans/printMultiple', [ScanController::class, 'printMultiple'])->name('scans.printMultiple');

/** Scan Notification Routes */
Route::get('clear-notification', [LabController::class, 'clearNotification'])->name('clear-notification');


//Order Routes
Route::resource('orders', OrderController::class);

/** chat Routes */
Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

/** Notification Routes */
Route::get('/notifications/seen/{notification}', [NotificationController::class, 'markAsSeen'])->name('notifications.seen');
Route::resource('notifications', NotificationController::class);


/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
