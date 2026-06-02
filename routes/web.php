<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use App\Http\Controllers\PanelControl\MovieController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('register.process');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');

Route::prefix('controll-panel')->middleware('checkLogin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/favorite', [DashboardController::class, 'favorite'])->name('favorite');
    Route::get('/movies', [MovieController::class, 'index'])->name('panel.movies');

    //Route untuk detail movie
    Route::get('/movies/detail/{id}', [MovieController::class, 'detail'])->name('movies.detail');

    // Routes untuk Favorite Controller
    Route::post('/favorite/toggle', [\App\Http\Controllers\PanelControl\FavoriteController::class, 'toggle'])->name('favorite.toggle');
    Route::get('/favorite/check/{imdbId}', [\App\Http\Controllers\PanelControl\FavoriteController::class, 'check'])->name('favorite.check');
    Route::get('/favorite/list', [\App\Http\Controllers\PanelControl\FavoriteController::class, 'getFavorites'])->name('favorite.list');
});


Route::get('lang/{locale}', [AuthController::class, 'switchLang'])->name('lang.switch');
