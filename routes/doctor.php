<?php

use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\NotificationController;
use App\Http\Controllers\Doctor\OrderController;
use App\Http\Controllers\Doctor\PatientController;
use App\Http\Controllers\Doctor\PaymentController;
use App\Http\Controllers\Doctor\ScanController;
use App\Http\Controllers\Doctor\ProfileController;
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

Route::get('new_scan/{id}', [ScanController::class, 'newScan'])->name('scans.new');
Route::post('new_scan/{id}/store', [ScanController::class, 'newScanStore'])->name('scans.new.store');
Route::resource('scans', ScanController::class);
Route::resource('patients', PatientController::class);

/** Orders Routes */
Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
Route::get('/orders/rejected', [OrderController::class, 'rejected'])->name('orders.rejected');
Route::get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
Route::get('/orders/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
Route::resource('orders', OrderController::class);

/** Notifications Routes */
Route::get('/notifications/seen/{notification}', [NotificationController::class, 'markAsSeen'])->name('notifications.seen');
Route::resource('notifications', NotificationController::class);


/** Notification Routes */
Route::get('clear-notification', [DoctorController::class, 'clearNotification'])->name('clear-notification');

/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

/** Payment Routes */
Route::get('/scans/{scan}/pay', [PaymentController::class, 'pay'])->name('scans.pay');
Route::post('/payment-callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
