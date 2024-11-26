<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ExpenseMenuController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ MainController::class, 'show_home' ] )->middleware( 'auth' )->name( 'home' );

// 経費メニュー用ルーティング
Route::get( '/expense-menu', [ ExpenseMenuController::class, 'show_expense_menu' ] )->name( 'expense' );

//ログイン用ルーティング
Route::get( '/login', [ AuthController::class, 'showLoginForm' ] )->name( 'login' );
Route::post( '/login', [ AuthController::class, 'login' ] )->name( 'login.attempt' );
Route::post( '/logout', [ AuthController::class, 'logout' ] )->name( 'logout.attempt' );

