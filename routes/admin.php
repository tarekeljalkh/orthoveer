<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ExternalLabController;
use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TypeofWorkController;
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
Route::put('labs/{id}/updatePassword', [LabController::class, 'updatePassword'])->name('labs.updatePassword');
Route::resource('labs', LabController::class);

//External Labs section Routes
Route::put('external_labs/{id}/updatePassword', [ExternalLabController::class, 'updatePassword'])->name('external_labs.updatePassword');
Route::resource('external_labs', ExternalLabController::class);

//TypeofWorks Routes
Route::resource('type-of-works', TypeofWorkController::class);

/** Setting Routes */
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');


/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

/** chat Routes */
Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');


/** Notifications Routes */
Route::resource('notifications', NotificationController::class);
