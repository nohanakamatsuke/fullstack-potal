<?php
// 経費メニューのコントローラー
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseFormController extends MainController {

    public function show_expense_form( Request $request ) {

        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        //直前のページURLを取得
        $prevurl = url()->previous();

        return  view( 'expense-form', compact( 'user_id', 'name', 'prevurl' ) );
    }

}
