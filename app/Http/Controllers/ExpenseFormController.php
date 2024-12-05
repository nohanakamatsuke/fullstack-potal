<?php
// 経費メニューのコントローラー
// ここで、確認画面に遷移する前のバリデートを行う
namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExpenseFormController extends MainController
{
  public function show_expense_form(Request $request)
  {
    // 親クラスから、メソッドを呼び出す
    $this->show_home($request);
    $name = $this->name;
    // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
    $user_id = $this->user_id;
    //直前のページURLを取得
    $prevurl = url()->previous();
    return view('expense-form', compact('user_id', 'name', 'prevurl'));
  }
  //確認画面に飛ばすメソッド　
  public function expense_form_submit_confirm(Request $request)
  {
    // 親クラスから、メソッドを呼び出す
    $this->show_home($request);
    $name = $this->name;
    $user_id = $this->user_id;
    // フォームの件数を、dateの配列数から取得して、セッションに保存
    $formCount = count($request->input('date', []));
    session(['form_count' => $formCount]);
    //dd( $formCount );
    // 必須項目のバリデート
    try {
      $validated = $request->validate([
        'receipt-front.*' => 'required',
        'receipt-back.*' => 'required',
        'date.*' => 'required',
        'item.*' => 'required',
        'purpose.*' => 'required|string',
        'total-amount.*' => 'required',
      ], [
        'required' => '全ての項目を入力してください',
      ]);
      // 発生したエラーを$errorで元のビューにエラーメッセージと、入力情報を渡す
    } catch (ValidationException $error) {
      return back()->withErrors($error->validator)->withInput();
    }
    // session( [ 'form_input', $validated ] );
    // バリデート成功した場合
    return view('expense-confirm', compact('name', 'user_id', 'validated', 'formCount'));
    // return redirect() -> intended( 'expense-confirm' );
  }
  public function show_expense_confirm(Request $request)
  {
    // $validated = $request->all();
    // 親クラスから、メソッドを呼び出す
    $this->show_home($request);
    $name = $this->name;
    $user_id = $this->user_id;
    return view('expense-confirm', compact('name', 'user_id'));
  }

  //トークン取得用のstoreメソッド
  //申請完了ボタン押下で、データベースへ登録するメソッド記入
  public function store(Request $request)
  {
    // 配列データを取得
    // $dates = $request->input('date');
    // $items = $request->input('item');
    // $purposes = $request->input('purpose');
    // $totalAmounts = $request->input('total-amount');
    $dates = $request->input('use_date');
    $items = $request->input('item');
    $purposes = $request->input('purpose');
    $receiptFronts = $request->input('receipt_front');
    $receiptBacks = $request->input('receipt_back');
    $totalAmounts = $request->input('total_amount');
    // データベースに登録
    foreach ($dates as $index => $startDate) {
      ExpenseApp::create([
        // 'start_date' => $startDate,
        // 'end_date' => $startDate, // 終了日が同じ場合はこのまま
        // 'item' => $items[$index] ?? null,
        // 'purpose' => $purposes[$index] ?? null,
        // 'total_amount' => $totalAmounts[$index] ?? null,
        'user_id' => auth()->id(),
        'use_date' => $useDate,
        'item' => $items[$index] ?? null,
        'purpose' => $purposes[$index] ?? null,
        'receipt_front' => $receiptFronts[$index] ?? null,
        'receipt_back' => $receiptBacks[$index] ?? null,
        'total_amount' => $totalAmounts[$index] ?? null,
        'expense_app_line_templates' => 'default_template', // 適切な値を設定
        'account_items' => 'default_account', // 適切な値を設定
        'freee_sync_status' => 0,
      ]);
    }
    // 登録完了後、確認ページにリダイレクト
    return redirect()->route('test_comp');
  }
}
