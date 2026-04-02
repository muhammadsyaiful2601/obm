<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/masuk', function () {
    return view('controll panel.movie');
});
Route::get('/favorite', function () {
    return view('controll panel.favorite');
});

Route::get('/keluar', function () {
    return view('auth.login');
});
