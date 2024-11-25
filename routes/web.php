<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [SessionController::class, 'session']);
Route::get('/', [SessionController::class, 'session'])->name('home');
//ログイン用ルーティング
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-session', [AuthController::class, 'testSession']);
