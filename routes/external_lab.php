<?php

use App\Http\Controllers\ExternalLab\ExternalLabController;
use App\Http\Controllers\ExternalLab\NotificationController;
use App\Http\Controllers\ExternalLab\ProfileController;
use App\Http\Controllers\ExternalLab\ScanController;
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

/** Scan Notification Routes */
Route::get('clear-notification', [LabController::class, 'clearNotification'])->name('clear-notification');

/** Notification Routes */
Route::get('/notifications/seen/{notification}', [NotificationController::class, 'markAsSeen'])->name('notifications.seen');
Route::resource('notifications', NotificationController::class);




/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
