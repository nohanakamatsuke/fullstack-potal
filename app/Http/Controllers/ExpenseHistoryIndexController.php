<?php

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;

class ExpenseHistoryIndexController extends MainController
{
    public function history_index(Request $request)
    {
        // MainControllerのshow_homeメソッドを呼び出し
        $this->show_home($request);
    // MainControllerから継承した値をローカル変数に変換
    $name = $this->name;
    $user_id = $this->user_id;
        // クエリの基本部分を構築
        $query = ExpenseApp::join('users', 'expense_app.user_id', '=', 'users.user_id');

        // 検索機能
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('expense_app.item', 'like', "%{$search}%")
                  ->orWhere('expense_app.purpose', 'like', "%{$search}%");
            });
        }

        // 日付範囲検索
        if ($request->filled('start_date')) {
            $query->whereDate('expense_app.use_date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('expense_app.use_date', '<=', $request->input('end_date'));
        }

        // 承認状態での絞り込み
        if ($request->filled('status')) {
            $query->where('expense_app.freee_sync_status', $request->input('status'));
        }

        // データの取得
        $expenses = $query->select([
            'users.user_id',
            'users.name',
            'expense_app.use_date',
            'expense_app.item',
            'expense_app.total_amount',
            'expense_app.freee_sync_status',
            'expense_app.purpose',
            'expense_app.expense_id' // 詳細ページへのリンク用

        ])
        ->orderBy('expense_app.use_date', 'desc')
        ->paginate(15);

        // 承認状態を各レコードに追加
        $expenses->getCollection()->transform(function ($expense) {
            $expense->status = ($expense->freee_sync_status === 0) ? '承認' : '未承認';
            return $expense;
        });
        // 検索パラメータをページネーションリンクに追加
        $expenses->appends($request->all());

        // 検索フォームの初期値用
        $search_params = [
            'search' => $request->input('search'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $request->input('status')
        ];

        // 経費メニューページへのURLを設定
        $prevurl = route('expense');

        return view('expense-history-index', compact(
            'expenses',
            'prevurl',
            'search_params',
            'user_id',
            'name'
        ));
    }
}
