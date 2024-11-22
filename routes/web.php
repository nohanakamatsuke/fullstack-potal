<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ MainController::class, 'show_home' ] );

//ログイン用ルーティング
Route::get( '/login', [ AuthController::class, 'showLoginForm' ] )->name( 'login' );
Route::post( '/login', [ AuthController::class, 'login' ] )->name( 'login.attempt' );
Route::post( '/logout', [ AuthController::class, 'logout' ] )->name( 'logout' );
