<?php

use App\Http\Controllers\DHLController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/create-storage-link', function () {
    Artisan::call('storage:link');
    return 'The storage link has been created!';
});

// all middlewares, prefixes and suffixes are in routeserviceprovider

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        $roleRedirects = [
            'admin' => '/admin/dashboard',
            'doctor' => '/doctor/dashboard',
            'lab' => '/lab/dashboard',
            'second_lab' => '/second_lab/dashboard',
            'external_lab' => '/external_lab/dashboard',
        ];

        return redirect($roleRedirects[$role] ?? '/');
    }

    return view('auth.login');
});

Route::get('/setlang/{locale}', [LocalizationController::class, 'setLang'])->name('setLang');


Route::get('/test', function () {
    return view('layouts.master');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

