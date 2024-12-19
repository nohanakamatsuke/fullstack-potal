<?php

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ExpenseHistoryIndexController extends MainController
{
  public function history_index(Request $request)
  {
    // MainControllerのshow_homeメソッドを呼び出し
    $this->show_home($request);
    // MainControllerから継承した値をローカル変数に変換
    $name = $this->name;
    $user_id = $this->user_id;

    //freee申請履歴表示
    //freeeのcompanyId
    $companyId = ENV('COMPANY_ID');

    //検索フォームの初期値用
    $search_params = [
      'search' => $request->input('search'),
      'start_date' => $request->input('start_date'),
      'end_date' => $request->input('end_date'),
      'status' => $request->input('status'),
    ];

    //検索項目に入力されているものあるか確認
    $inputKeyword = is_null($search_params['search']) ? ' ' : $search_params['search'];
    $inputStartDate = is_null($search_params['start_date']) ? ' ' : $search_params['start_date'];
    $inputEndDate = is_null($search_params['end_date']) ? ' ' : $search_params['end_date'];
    $inputStatus = $search_params['status'] === '承認状態' ? ' ' : $search_params['status'];

    //freee申請履歴取得
    $url = 'https://api.freee.co.jp/api/1/expense_applications';
    //freee経費申請履歴リクエスト
    $freeeExpenses = Http::withToken(session('freee_access_token'))->get($url, [
      'company_id' => $companyId,
      'status' => $inputStatus,
      'title' => $inputKeyword,
      'start_issue_date' => $inputStartDate,
      'end_issue_date' => $inputEndDate,
      'applicant_id' => session('freee_user_id'),
    ]);
    $expense_applications = $freeeExpenses['expense_applications'];

    //expense-menuに表示させるために、整形
    $ViewExpenses = [];
    if (!empty($expense_applications)) {
      foreach ($expense_applications as $expense) {
        $judgeStatus = ($expense['status'] === 'in_progress') ? '未承認' : '承認';
        $ViewExpenses[] = [
          'use_date' => $expense['issue_date'],
          'user_id' => $user_id,
          'name' => $name,
          'title' => $expense['title'],
          // 'item' => ' ',
          // 'purpose' => ' ',
          'total_amount' => $expense['total_amount'],
          'status' => $judgeStatus,
        ];
      }
    }

    //ページネーション適用、申請日時で降順に並び替え
    $pagenateData = collect($ViewExpenses)->sortByDesc('issue_date');
    // 1ページごとの表示件数
    $perPage = 15;
    // 現在のページを取得
    $page = Paginator::resolveCurrentPage('page');
    // ページ番号から表示するデータを指定
    $pageData = $pagenateData->slice(($page - 1) * $perPage, $perPage);
    $options = [
      'path' => Paginator::resolveCurrentPath(),
      'pageName' => 'page'
    ];
    $paginatedData = new LengthAwarePaginator($pageData, $pagenateData->count(), $perPage, $page, $options);


    // // クエリの基本部分を構築
    // $query = ExpenseApp::join('users', 'expense_app.user_id', '=', 'users.user_id');

    // // 検索機能
    // if ($request->filled('search')) {
    //   $search = $request->input('search');
    //   $query->where(function ($q) use ($search) {
    //     $q->where('users.name', 'like', "%{$search}%")
    //       ->orWhere('expense_app.item', 'like', "%{$search}%")
    //       ->orWhere('expense_app.purpose', 'like', "%{$search}%");
    //   });
    // }

    // // 日付範囲検索
    // if ($request->filled('start_date')) {
    //   $query->whereDate('expense_app.use_date', '>=', $request->input('start_date'));
    // }
    // if ($request->filled('end_date')) {
    //   $query->whereDate('expense_app.use_date', '<=', $request->input('end_date'));
    // }

    // // 承認状態での絞り込み
    // if ($request->filled('status')) {
    //   $query->where('expense_app.freee_sync_status', $request->input('status'));
    // }

    // // データの取得
    // $expenses = $query->select([
    //   'users.user_id',
    //   'users.name',
    //   'expense_app.use_date',
    //   'expense_app.item',
    //   'expense_app.total_amount',
    //   'expense_app.freee_sync_status',
    //   'expense_app.purpose',
    //   'expense_app.expense_id' // 詳細ページへのリンク用

    // ])
    //   ->orderBy('expense_app.use_date', 'desc')
    //   ->paginate(15);

    // // 承認状態を各レコードに追加
    // $expenses->getCollection()->transform(function ($expense) {
    //   $expense->status = ($expense->freee_sync_status === 0) ? '承認' : '未承認';
    //   return $expense;
    // });
    // // 検索パラメータをページネーションリンクに追加
    // $expenses->appends($request->all());

    // 経費メニューページへのURLを設定
    $prevurl = route('expense');

    // return view('expense-history-index', compact(
    //   'expenses',
    //   'prevurl',
    //   'search_params',
    //   'user_id',
    //   'name'
    // ));
    return view('expense-history-index', compact(
      'paginatedData',
      'prevurl',
      'search_params',
      'user_id',
      'name'
    ));
  }
}
