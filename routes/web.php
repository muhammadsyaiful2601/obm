<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('register.process');

Route::get('/masuk', function () {
    return view('controll panel.movie');
})->name('dashboard');

Route::get('/favorite', function () {
    return view('controll panel.favorite');
})->name('favorite');

Route::get('/keluar', function () {
    return redirect()->route('login');
})->name('logout');
