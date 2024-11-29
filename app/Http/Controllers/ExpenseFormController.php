<?php
// 経費メニューのコントローラー
// ここで、確認画面に遷移する前のバリデートを行う

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\ExpenseApp;
use Illuminate\Http\Request;

class ExpenseFormController extends MainController {

    public function show_expense_form( Request $request ) {

        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );
        $name = $this->name;
        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $user_id = $this->user_id;

        //直前のページURLを取得
        $prevurl = url()->previous();

        return  view( 'expense-form', compact( 'user_id', 'name', 'prevurl' ) );

    }

    public function expense_form_submit ( Request $request ) {
        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );
        $name = $this->name;
        $user_id = $this->user_id;
        // フォームの件数を、dateの配列数から取得して、セッションに保存
        $formCount = count( $request->input( 'date', [] ) );
        session( [ 'form_count' => $formCount ] );

        //dd( $formCount );

        // 必須項目のバリデート
        try {
            $validated = $request->validate( [
                'receipt-front.*' => 'required',
                'receipt-back.*' => 'required',
                'date.*' => 'required',
                'item.*' => 'required',
                'purpose.*' => 'required|string',
                'total-amount.*' => 'required',
            ], [
                'required' => '全ての項目を入力してください'
            ] );
            // 発生したエラーを$errorで元のビューにエラーメッセージと、入力情報を渡す
        } catch( ValidationException $error ) {
            return back() ->withErrors( $error->validator )->withInput();
        }

        // session( [ 'form_input', $validated ] );

        // バリデート成功した場合
        return view ( 'expense-confirm', compact( 'name', 'user_id', 'validated', 'formCount' ) );
        // return redirect() -> intended( 'expense-confirm' );
    }

    public function show_expense_confirm ( Request $request ) {

        // $validated = $request->all();

        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );
        $name = $this->name;
        $user_id = $this->user_id;

        return view ( 'expense-confirm', compact( 'name', 'user_id' ) );
    }

}