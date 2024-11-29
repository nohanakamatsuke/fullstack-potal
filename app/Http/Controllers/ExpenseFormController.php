<?php
// 経費メニューのコントローラー
// ここで、確認画面に遷移する前のバリデートを行う

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use App\Models\ExpenseApp;
use Illuminate\Http\Request;

class ExpenseFormController extends MainController {

    public function show_expense_form( Request $request ) {

        $this->show_home( $request );
        // 親クラスから、メソッドを呼び出す

        $name = $this->name;
        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $user_id = $this->user_id;

        $prevurl = url()->previous();
        //直前のページURLを取得

        return  view( 'expense-form', compact( 'user_id', 'name', 'prevurl' ) );

    }

    public function expense_form_submit ( Request $request ) {
        // フォームの件数を、dateの配列数から取得して、セッションに保存
        $formCount = count( $request->input( 'date', [] ) );
        session( [ 'form_count' => $formCount ] );
        dd( $request );
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
        // バリデート成功した場合
        return redirect() -> intended( 'expense-confirm' );
    }

    // テスト用で、配置しているが確認画面を作成する際は、新しくコントローラーを作成する

    public function show_expense_confirm (Request $request) {

      // 配列データの取得
      $dates = $request->input('date');
      $items = $request->input('item');
      $purposes = $request->input('purpose');
      $totalAmounts = $request->input('total-amount');

      // ループでデータを個別に登録
      foreach ($dates as $index => $startDate) {
        ExpenseApp::create([
              'start_date' => $startDate,
              'end_date' => $startDate, // 終了日が同じならこのまま。違うならリクエストから取得
              'item' => $items[$index] ?? null, // 配列外アクセスを防ぐため ?? null を追加
              'purpose' => $purposes[$index] ?? null,
              'total_amount' => $totalAmounts[$index] ?? null,
          ]);
      }
        return view ( 'expense-confirm' );
    }

}

