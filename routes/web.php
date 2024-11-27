<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ExpenseMenuController;
use App\Http\Controllers\ExpenseFormController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [ MainController::class, 'show_home' ] )->middleware( 'auth' )->name( 'home' );

// 経費メニュー用ルーティング
Route::get( '/expense-menu', [ ExpenseMenuController::class, 'show_expense_menu' ] )->middleware( 'auth' )->name( 'expense' );

// 経費申請フォーム用ルーティング
Route::get( '/expense-form', [ ExpenseFormController::class, 'show_expense_form' ] )->middleware( 'auth' )->name( 'expense' );
Route::post( '/expense-form', [ ExpenseFormController::class, 'expense_form_submit' ] )->middleware( 'auth' )->name( 'expense' );

// 確認画面用ルーティング
Route::get( '/expense-confirm', [ ExpenseFormController::class, 'show_expense_confirm' ] )->middleware( 'auth' )->name( 'confirm' );

//ログイン用ルーティング
Route::get( '/login', [ AuthController::class, 'showLoginForm' ] )->name( 'login' );
Route::post( '/login', [ AuthController::class, 'login' ] )->name( 'login.attempt' );
Route::post( '/logout', [ AuthController::class, 'logout' ] )->name( 'logout.attempt' );

