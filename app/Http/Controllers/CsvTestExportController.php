<?php

namespace App\Http\Controllers;

use App\Models\ExpenseApp;
use Illuminate\Support\Facades\Response;

class CsvTestExportController extends Controller
{
    public function csvMonitor()
    {
        $expenses = ExpenseApp::all();

        return view('export-csv', compact('expenses'));
    }

    public function exportCsv()
    {
        $expenses = ExpenseApp::all();

        $csvFileName = 'expenses.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$csvFileName.'"',
        ];

        $callback = function () use ($expenses) {
            $file = fopen('php://output', 'w');

            // ヘッダー行を追加
            fputcsv($file, array_map(function ($header) {
                return mb_convert_encoding($header, 'SJIS', 'UTF-8');
            }, ['ユーザーID', '使用日', '用途項目', '金額', '目的']));

            // データをCSVに書き込む
            foreach ($expenses as $expense) {
                fputcsv($file, array_map(function ($field) {
                    return mb_convert_encoding($field, 'SJIS', 'UTF-8');
                }, [
                    $expense->user_id,
                    $expense->use_date,
                    $expense->item,
                    $expense->total_amount,
                    $expense->purpose,
                ]));
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
