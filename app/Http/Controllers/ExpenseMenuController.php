<?php

// 経費メニューのコントローラー

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExpenseMenuController extends MainController
{
  public function show_expense_menu(Request $request)
  {
    // 親クラスから、メソッドを呼び出す
    $this->show_home($request);

    // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
    $name = $this->name;
    $user_id = $this->user_id;

    // セッションにFreeeトークン情報が保存されていなければ、認証画面に飛ばす
    if (!session()->has('freee_access_token') || !session()->has('freee_refresh_token')) {
      return redirect()->route('auth/freee');
    }

    //freeeのcompanyId
    $companyId = ENV('COMPANY_ID');

    //ログイン中のユーザーのfreeeID取得
    //ログインユーザー情報取得のエンドポイント
    $userInfoUrl = 'https://api.freee.co.jp/api/1/users/me';
    //ユーザー情報取得リクエスト
    $userInfo = Http::withToken(session('freee_access_token'))->get($userInfoUrl);
    //freeeユーザーIDをセッションに保存
    session(['freee_user_id' => $userInfo['user']['id']]);

    //freee申請履歴取得
    $expenseHistoryUrl = 'https://api.freee.co.jp/api/1/expense_applications';
    //freee経費申請履歴リクエスト
    $freeeExpenses = (Http::withToken(session('freee_access_token'))->get($expenseHistoryUrl, [
      'company_id' => $companyId,
      'applicant_id' => session('freee_user_id'),
    ]));
    //コレクション生成
    $expense_applications = collect($freeeExpenses['expense_applications']);

    //expense-menuに表示させるために、整形
    $ViewExpenses = [];
    if (!empty($expense_applications)) {
      // 直近6件のデータを取得
      $recentExpenses = $expense_applications->sortByDesc('issue_date')->take(6);
      foreach ($recentExpenses as $expense) {
        // 申請ごとのidを内部キーとして使用
        $key = $expense['id'];
        // データの重複を防ぐ
        if (!isset($ViewExpenses[$key])) {
          $status = ($expense['status'] === 'in_progress') ? '未承認' : '承認';
          // 表示用キーを生成（idを含まない）
          $displayKey = date('Y/m/d', strtotime($expense['issue_date'])) .
            ' ¥' . number_format($expense['total_amount']);
          // 表示用データを格納
          $ViewExpenses[$key] = [
            'key' => $displayKey, // 表示用キー
            'status' => $status
          ];
        }
      }
    } else {
      Log::info('申請履歴が存在しません。');
    }

    // 経費メニュー内、ボタン情報の指定
    $inExpenseMenuButton = [
      ['label' => '申請', 'status' => 1, 'route' => 'expense-form'],
      ['label' => '履歴', 'status' => 1, 'route' => 'history_index'],
    ];

    // ExpenseAppモデルから必要なカラムのみ取得
    // $expenses = ExpenseApp::where('user_id', $user_id)
    //   ->select('use_date', 'item', 'total_amount', 'freee_sync_status')
    //   ->orderBy('use_date', 'desc')
    //   ->get();

    // $expenseHistory = [];
    // foreach ($expenses->take(6) as $expense) {
    //   // freee_sync_statusに応じて承認状態を設定
    //   $expense_status = ($expense->freee_sync_status === 0) ? '承認' : '未承認';

    //   // 日付、項目、金額を整形して履歴に追加
    //   $key = date('Y/m/d', strtotime($expense->use_date)) . ' ' .
    //     $expense->item . PHP_EOL . ' ￥' . number_format($expense->total_amount);
    //   $expenseHistory[$key] = $expense_status;
    // }

    //直前のページURLを取得
    $prevurl = url()->previous();

    // return view('expense-menu', compact('user_id', 'name', 'inExpenseMenuButton', 'expenseHistory', 'prevurl', 'expenses'));
    return view('expense-menu', compact('user_id', 'name', 'inExpenseMenuButton', 'ViewExpenses', 'prevurl'));
  }

  public function create()
  {
    // 経費申請フォーム
  }

  public function history()
  {
    // 経費一覧
  }
}
