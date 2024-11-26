<?php
// 経費メニューのコントローラー
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseMenuController extends MainController {

    public function show_expense_menu( Request $request ) {

        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        $inExpenseMenuButton = [
            [ 'label' =>'申請', 'status' => 1, 'route' => '' ],
            [ 'label' =>'履歴', 'status' => 0, 'route' => '' ],
        ];
        $expenseHistory = [
            '2024/11/11 交通費 ￥5600' => '承認',
            '2024/10/07 その他 ￥3600' => '承認',
            '2024/08/08 その他 ￥8800' => '未承認'
        ];

        //直前のページURLを取得
        $prevurl = url()->previous();

        return  view( 'expense-menu', compact( 'user_id', 'name', 'inExpenseMenuButton', 'expenseHistory', 'prevurl' ) );
    }

    public function create() {
        // 経費申請フォーム
    }

    public function history() {
        // 経費一覧
    }

}
