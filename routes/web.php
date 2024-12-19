<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CsvTestExportController;
use App\Http\Controllers\ExpenseFormController;
use App\Http\Controllers\ExpenseHistoryIndexController;
use App\Http\Controllers\ExpenseMenuController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\FreeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'show_home'])->middleware('auth')->name('home');

// 経費メニュー用ルーティング
Route::get('/expense-menu', [ExpenseMenuController::class, 'show_expense_menu'])->middleware('auth')->name('expense');

// 【経費申請フォーム用ルーティング】
Route::post('/expense-submit', [ExpenseFormController::class, 'expense_form_submit_confirm'])->middleware('auth')->name('expense.submit.confirm');

// 確認画面用ルーティング
Route::get('/expense-confirm', [ExpenseFormController::class, 'show_expense_confirm'])->middleware('auth')->name('expense.confirm');

//【csv出力用　経費申請】
//確認画面表示
Route::get('/expense-form', [ExpenseFormController::class, 'show_expense_form'])->middleware('auth')->name('expense.form');
// データ登録 (POST)　経費申請完了
Route::post('/expense_store', [ExpenseFormController::class, 'expense_store'])->middleware('auth')->name('expense.store');

//ログイン用ルーティング
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.attempt');

//APIトークン取得　現状使っていない
Route::post('/expence-register', [ExpenseFormController::class, 'store'])->middleware('auth')->name('expence-register');
Route::get('/test_comp', function () {
  return view('test_comp');
})->name('test_comp');

//テスト用csv出力
Route::get('/csvMonitor', [CsvTestExportController::class, 'csvMonitor'])->name('csvMonitor');
Route::post('/testcsv', [CsvTestExportController::class, 'exportCsv'])->name('testcsv');

// 経費申請履歴
Route::get('/history_index', [ExpenseHistoryIndexController::class, 'history_index'])->middleware('auth')->name('history_index');
//Freee
//認証用URL←認可コード取得
Route::get('/auth/freee', [FreeeController::class, 'redirectToFreee'])->middleware('auth')->name('auth/freee');
Route::get('/get-freeetoken', [FreeeController::class, 'handleCallback']);
Route::get('/get-access-token', [FreeeController::class, 'getAccessToken']);
Route::get('/get-information', [FreeeController::class, 'index']);


Route::get('/freee/callback', [FreeeController::class, 'handleCallBack']);
