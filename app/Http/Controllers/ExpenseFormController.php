<?php

// 経費メニューのコントローラー
// ここで、確認画面に遷移する前のバリデートを行う

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // 必須項目のバリデート
        try {
            $validated = $request->validate([
                'receipt_front.*' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // 画像のバリデーション
                'receipt_back.*' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // 画像のバリデーション
                'date.*' => 'required|date',
                'item.*' => 'required|string|max:255',
                'purpose.*' => 'required|string|max:500',
                'total_amount.*' => 'required|string|max:255',
            ], [
                'required' => '全ての項目を入力してください',
                'date' => '日付形式で入力してください',
                'string' => '文字列として入力してください',
                'max' => '最大 :max 文字まで入力可能です',
            ]);

            $receiptFrontPaths = [];
            $receiptBackPaths = [];

            // ファイル保存処理
            if ($request->hasFile('receipt_front')) {
                foreach ($request->file('receipt_front') as $file) {
                    $path = $file->store('receipts', 'public');
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
            $validated['total_amount'] = $validated['total_amount'] ?? array_fill(0, count($validated['date']), '');

            // 入力データをセッションに保存
            session(['form_input' => $validated]);
        } catch (ValidationException $error) {
            return back()->withErrors($error->validator)->withInput();
        }

        // 確認画面に遷移
        return view('expense-confirm', compact('name', 'user_id', 'validated', 'formCount'));
    }

    // GETメソッドで確認画面を表示
    public function show_expense_confirm(Request $request)
    {

        // $validated = $request->all();

        // 親クラスから、メソッドを呼び出す
        $this->show_home($request);

        $name = $this->name;
        $user_id = $this->user_id;

        // 必要なデータをセッションに保存
        session(['form_input' => $request->all()]);

        return view('expense-confirm', compact('name', 'user_id'));
    }

    //APIで登録する際のトークン取得用のメソッド　現状利用予定なし
    public function store(Request $request)
    {
        $dates = $request->input('date');
        $items = $request->input('item');
        $purposes = $request->input('purpose');
        $receiptFronts = $request->input('receipt_front');
        $receiptBacks = $request->input('receipt_back');
        $totalAmounts = $request->input('total_amount');

        foreach ($dates as $index => $date) {
            ExpenseApp::create([
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
        //dd('expence_storeに入った');
        logger()->info('リクエストデータ1:', $request->all());
        logger()->info('セッションデータ1:', session()->all());
        logger()->info('セッションデータ1:', session()->all());
        // セッションからデータを取得
        $validated = session('form_input');
        if (! $validated) {
            return redirect()->route('expense.form')->withErrors(['error' => 'セッションデータが見つかりません。']);
        }
        // dd($request);
        // dd(session('date'));
        // セッションデータを補完
        // $sessionData = $request->session()->all();
        $sessionData = session()->all();
        try {
            DB::beginTransaction();
            $dates = $sessionData['date'] ?? []; //ここで値が入っていない　
            // dd(session('date'));

            $items = $sessionData['item'] ?? [];

            $purposes = $sessionData['purpose'] ?? [];

            $totalAmounts = $sessionData['total_amount'] ?? [];
            $receiptFrontPaths = $sessionData['receipt_front'] ?? [];
            $receiptBackPaths = $sessionData['receipt_back'] ?? [];
            logger()->info('リクエストデータ2:', $request->all());
            logger()->info('セッションデータ2:', session()->all());

            // データベースに登録 ここでdあてｓ
            // dd($dates);
            foreach ($dates as $index => $date) {
                ExpenseApp::create([
                    'user_id' => auth()->id(),
                    'use_date' => $startDate,  // 修正
                    'item' => $items[$index] ?? '',
                    'purpose' => $purposes[$index] ?? '',
                    'receipt_front' => $receiptFrontPaths[$index] ?? '',
                    'receipt_back' => $receiptBackPaths[$index] ?? '',
                    'total_amount' => $totalAmounts[$index] ?? '',
                    'expense_app_line_templates' => 'default_template',
                    'account_items' => 'default_account',
                    'freee_sync_status' => 0,
                ]);
            }
            logger()->info('リクエストデータ3:', $request->all());
            logger()->info('セッションデータ3:', session()->all());

            DB::commit();

            session()->flash('success', '経費申請が登録されました！');

            if (! $validated) {
                return redirect()->route('expense.form')->withErrors(['error' => 'セッションデータが見つかりません。']);
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('エラー内容', ['exception' => $e->getMessage()]);

            return back()->withErrors(['error' => '経費申請の登録中にエラーが発生しました。'])->withInput();
        }
    }
}
