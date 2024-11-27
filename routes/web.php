<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ExpenseMenuController;
use App\Http\Controllers\ExpenseFormController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ MainController::class, 'show_home' ] )->middleware( 'auth' )->name( 'home' );

// 経費メニュー用ルーティング
Route::get( '/expense-menu', [ ExpenseMenuController::class, 'show_expense_menu' ] )->name( 'expense' );

// 経費申請フォーム用ルーティング
Route::get( '/expense-form', [ ExpenseFormController::class, 'show_expense_form' ] )->name( 'expense' );

//ログイン用ルーティング
Route::get( '/login', [ AuthController::class, 'showLoginForm' ] )->name( 'login' );
Route::post( '/login', [ AuthController::class, 'login' ] )->name( 'login.attempt' );
Route::post( '/logout', [ AuthController::class, 'logout' ] )->name( 'logout.attempt' );

