<?php

use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [AdController::class, 'index'])->name('home');

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register/store', [UserController::class, 'store'])->name('register.store');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.auth');

Route::post('/login/send-reset-link', [UserController::class, 'sendResetLink'])->name('login.sendresetlink');
Route::get('/reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', function () {
    Auth::logout();

    return redirect('/login');
})->name('logout');

Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('ad/create', [AdController::class, 'create'])->name('ad.create')->middleware('auth');
Route::post('ad/store', [AdController::class, 'store'])->name('ad.store')->middleware('auth');
Route::get('ad/edit/{ad}', [AdController::class, 'edit'])->name('ad.edit')->middleware('auth');
Route::put('ad/update/{ad}', [AdController::class, 'update'])->name('ad.update')->middleware('auth');
Route::delete('ad/destroy/{ad}', [AdController::class, 'destroy'])->name('ad.destroy')->middleware('auth');