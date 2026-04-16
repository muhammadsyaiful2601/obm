<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'index']);
Route::get('/register', [AuthController::class, 'register']);

Route::get('/masuk', function () {
    return view('controll panel.movie');
});
Route::get('/favorite', function () {
    return view('controll panel.favorite');
});

Route::get('/keluar', function () {
    return view('auth.login');
});
