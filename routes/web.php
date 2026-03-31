<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('auth.dashboard');
});
Route::get('/favorite', function () {
    return view('auth.favorite');
});

Route::get('/logout', function () {
    return view('auth.login');
});
