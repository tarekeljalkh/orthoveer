<?php

use App\Http\Controllers\Lab\LabController;
use App\Http\Controllers\Lab\NotificationController;
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
Route::get('scans/rejected', [ScanController::class, 'rejected'])->name('scans.rejected');
Route::get('scans/downloaded', [ScanController::class, 'downloaded'])->name('scans.downloaded');
Route::get('scans/completed', [ScanController::class, 'completed'])->name('scans.completed');
Route::get('scans/viewer/{id}', [ScanController::class, 'viewer'])->name('scans.viewer');
Route::get('scans/prescription/{id}', [ScanController::class, 'prescription'])->name('scans.prescription');
//reject Scan
Route::post('scans/{id}/update-status', [ScanController::class, 'updateStatus'])->name('scans.updateStatus');

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

/** Notification Routes */
Route::get('/notifications/seen/{notification}', [NotificationController::class, 'markAsSeen'])->name('notifications.seen');
Route::resource('notifications', NotificationController::class);


/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
