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
                'receipt_front.*' => 'nullable|string|max:255', // nullableで入力しなくてもOK
                'receipt_back.*' => 'nullable|string|max:255',  // nullableで入力しなくてもOK
                'date.*' => 'required|date',                   // 日付形式が必須
                'item.*' => 'required|string|max:255',         // 必須かつ文字列
                'purpose.*' => 'required|string|max:500',      // 必須かつ文字列
                'total_amount.*' => 'required|string|max:255', // 必須で文字列
            ], [
                'required' => '全ての項目を入力してください',
                'date' => '日付形式で入力してください',
                'string' => '文字列として入力してください',
                'max' => '最大 :max 文字まで入力可能です',
            ]);

            // 未入力フィールドを空文字列で補完（全キー保証）
            $validated['receipt_front'] = $validated['receipt_front'] ?? array_fill(0, count($validated['date']), '');
            $validated['receipt_back'] = $validated['receipt_back'] ?? array_fill(0, count($validated['date']), '');
            $validated['total_amount'] = $validated['total_amount'] ?? array_fill(0, count($validated['date']), '');

            // ファイル保存処理
            $receiptFrontPaths = [];
            $receiptBackPaths = [];

            if ($request->hasFile('receipt_front')) {
                foreach ($request->file('receipt_front') as $file) {
                    $path = $file->store('receipts', 'public'); // 'storage/receipts'に保存
                    $receiptFrontPaths[] = $path;
                }
            }

            if ($request->hasFile('receipt_back')) {
                foreach ($request->file('receipt_back') as $file) {
                    $path = $file->store('receipts', 'public'); // 'storage/receipts'に保存
                    $receiptBackPaths[] = $path;
                }
            }

            // セッション保存用データ作成
            $validated['receipt_front'] = $receiptFrontPaths ?: array_fill(0, count($validated['date']), '');
            $validated['receipt_back'] = $receiptBackPaths ?: array_fill(0, count($validated['date']), '');

            // フォーム件数をセッションに保存
            $formCount = count($validated['date']);
            session(['form_count' => $formCount]);

            // 入力データ全体をセッションに保存
            session(['form_input' => $validated]);
        } catch (ValidationException $error) {
            return back()->withErrors($error->validator)->withInput();
            // return redirect() -> intended( 'expense-confirm' );
        }

        // 確認画面に遷移
        return view('expense-confirm', compact('name', 'user_id', 'validated', 'formCount'));
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

    //データベースへ直接経費申請するメソッド(csvファイル抽出用)
    public function expence_store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'use_date' => 'required|array',
            'use_date.*' => 'required|date', // 日付形式
            'item' => 'required|array',
            'item.*' => 'required|string|max:255',
            'purpose' => 'required|array',
            'purpose.*' => 'required|string|max:500',
            'receipt_front' => 'nullable|array',
            'receipt_front.*' => 'nullable|string|max:255',
            'receipt_back' => 'nullable|array',
            'receipt_back.*' => 'nullable|string|max:255',
            'total_amount' => 'required|array',
            'total_amount.*' => 'required|numeric|min:0',
        ]);

        // データベースへの登録
        try {
            DB::beginTransaction(); // トランザクション開始

            $dates = $validated['use_date'];
            $items = $validated['item'];
            $purposes = $validated['purpose'];
            $receiptFronts = $validated['receipt_front'] ?? [];
            $receiptBacks = $validated['receipt_back'] ?? [];
            $totalAmounts = $validated['total_amount'];

            foreach ($dates as $index => $startDate) {
                ExpenseApp::create([
                    'user_id' => auth()->id(),
                    'use_date' => $startDate, // 修正
                    'item' => $items[$index] ?? null,
                    'purpose' => $purposes[$index] ?? null,
                    'receipt_front' => $receiptFronts[$index] ?? null,
                    'receipt_back' => $receiptBacks[$index] ?? null,
                    'total_amount' => $totalAmounts[$index] ?? null,
                    'expense_app_line_templates' => 'default_template',
                    'account_items' => 'default_account',
                    'freee_sync_status' => 0,
                ]);
            }

            DB::commit(); // トランザクションコミット
        } catch (\Exception $e) {
            DB::rollBack(); // トランザクションロールバック

            return back()->withErrors(['error' => '経費申請の登録中にエラーが発生しました。'])->withInput();
        }

        return redirect()->route('test_comp')->with('success', '経費申請が登録されました！');
    }
}
