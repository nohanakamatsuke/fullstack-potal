<?php

// 経費メニューのコントローラー

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;

class ExpenseMenuController extends MainController {
    public function show_expense_menu( Request $request ) {
        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        $inExpenseMenuButton = [

            [ 'label' => '申請', 'status' => 1, 'route' => 'expense-form' ],
            [ 'label' => '履歴', 'status' => 1, 'route' => 'history_index' ],
        ];
        // ExpenseAppモデルから必要なカラムのみ取得
        $expenses = ExpenseApp::where( 'user_id', $user_id )
        ->select( 'use_date', 'item', 'total_amount', 'freee_sync_status' )
        ->orderBy( 'use_date', 'desc' )
        ->get();

        $expenseHistory = [];
        foreach ( $expenses->take( 6 ) as $expense ) {
            // freee_sync_statusに応じて承認状態を設定
            $expense_status = ( $expense->freee_sync_status === 0 ) ? '承認' : '未承認';

            // 日付、項目、金額を整形して履歴に追加
            $key = date( 'Y/m/d', strtotime( $expense->use_date ) ).' '.
            $expense->item.' ￥'.number_format( $expense->total_amount );
            $expenseHistory[ $key ] = $expense_status;

        }

        //直前のページURLを取得
        $prevurl = url()->previous();

        return view( 'expense-menu', compact( 'user_id', 'name', 'inExpenseMenuButton', 'expenseHistory', 'prevurl', 'expenses' ) );
    }

    public function create() {
        // 経費申請フォーム
    }

    public function history() {
        // 経費一覧
    }
}
