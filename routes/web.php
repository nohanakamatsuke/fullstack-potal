<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseFormController;
use App\Http\Controllers\ExpenseMenuController;
use App\Http\Controllers\FreeeController;
use App\Http\Controllers\MainController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'show_home'])->middleware('auth')->name('home');
// 経費メニュー用ルーティング
Route::get('/expense-menu', [ExpenseMenuController::class, 'show_expense_menu'])->middleware('auth')->name('expense');
// 経費申請フォーム用ルーティング
Route::get('/expense-form', [ExpenseFormController::class, 'show_expense_form'])->middleware('auth')->name('expense.form');
Route::post('/expense-submit', [ExpenseFormController::class, 'expense_form_submit_confirm'])->middleware('auth')->name('expense.submit.confirm');
// 確認画面用ルーティング
Route::get('/expense-confirm', [ExpenseFormController::class, 'show_expense_confirm'])->middleware('auth')->name('expense.confirm');
// 経費申請確定→12/3postmanでアクセストークン取得までする
Route::post('/expence-register', [ExpenseFormController::class, 'store'])->middleware('auth')->name('expence-register');
Route::get('/test_comp', function () {
  return view('test_comp');
})->name('test_comp');
//ログイン用ルーティング
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.attempt');
//ルート記載関数

//Freee
//認証用URL←認可コード取得
Route::get('/auth/freee', [FreeeController::class, 'redirectToFreee']);
Route::get('/get-freeetoken', [FreeeController::class, 'handleCallback']);
Route::get('/get-access-token', [FreeeController::class, 'getAccessToken']);
Route::get('/get-information', [FreeeController::class, 'index']);
