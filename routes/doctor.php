<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\ScanController;
use App\Http\Controllers\Doctor\OrderController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\PatientController;
use App\Http\Controllers\Doctor\PaymentController;
use App\Http\Controllers\Doctor\ProfileController;
use App\Http\Controllers\Doctor\NotificationController;
use App\Http\Controllers\Doctor\TreatmentPlanController;

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


Route::get('treatment-plans', [TreatmentPlanController::class, 'index'])->name('treatment-plans.index');
Route::get('treatment-plans/create', [TreatmentPlanController::class, 'create'])->name('treatment-plans.create');
Route::post('treatment-plans', [TreatmentPlanController::class, 'store'])->name('treatment-plans.store');


Route::get('treatment-plans/{id}/review', [TreatmentPlanController::class, 'review'])->name('doctor.treatment-plans.review');
Route::post('treatment-plans/{id}/approve', [TreatmentPlanController::class, 'approve'])->name('doctor.treatment-plans.approve');
Route::post('treatment-plans/{id}/reject', [TreatmentPlanController::class, 'reject'])->name('doctor.treatment-plans.reject');
Route::prefix('doctor/treatment-plans')->name('treatment-plans.')->group(function () {
    Route::patch('{id}/accept', [TreatmentPlanController::class, 'accept'])->name('accept');
    Route::patch('{id}/refuse', [TreatmentPlanController::class, 'refuse'])->name('refuse');
});
