<?php

// 経費メニューのコントローラー

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseApp;

class ExpenseMenuController extends MainController
{
    public function show_expense_menu(Request $request)
    {

        // 親クラスから、メソッドを呼び出す
        $this->show_home($request);

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        $inExpenseMenuButton = [
            ['label' => '申請', 'status' => 1, 'route' => 'expense-form'],
            ['label' => '履歴', 'status' => 0, 'route' => ''],//後で消す　ここに履歴一覧のページを入れれば飛ばせる
        ];
        //経費一覧の取得
        $expenseHistory = [
            '2024/11/11 交通費 ￥5600' => '承認',
            '2024/10/07 その他 ￥3600' => '承認',
            '2024/08/08 その他 ￥8800' => '未承認',
        ];
        $expenses = ExpenseApp::select('user_id', 'name', 'total_amount', 'created_at')
            ->orderBy('use_date', 'desc')
            ->take(5)
            ->get();

        //直前のページURLを取得
        $prevurl = url()->previous();

        return view('expense-menu', compact('user_id', 'name', 'inExpenseMenuButton', 'expenseHistory', 'prevurl','expenses'));
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
