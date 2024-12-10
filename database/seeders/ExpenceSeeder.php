<?php

namespace Database\Seeders;

use App\Models\ExpenseApp;
use Illuminate\Database\Seeder;

class ExpenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseApp::create([
            'expense_id' => '1',
            'receipt_front' => 'test_photo1',
            'receipt_back' => 'test_photo2',
            'use_date' => '2024-12-03',
            'expense_app_line_templates' => '交通費',
            'item' => '交通費',
            'purpose' => '京橋から東京駅までの乗車賃',
            'total_amount' => '300',
            'user_id' => '_1234', //userテーブルから取得予定
            'name' => '山田太郎1号',
            'account_items' => '電車代',
            'freee_sync_status' => '0',
        ]);
        ExpenseApp::create([
            'expense_id' => '2',
            'receipt_front' => 'test_photo1',
            'receipt_back' => 'test_photo2',
            'use_date' => '2024-12-03',
            'expense_app_line_templates' => '交通費',
            'item' => '交通費',
            'purpose' => '京橋から東京駅までの乗車賃',
            'total_amount' => '400',
            'user_id' => '_5678', //userテーブルから取得予定
            'name' => '山田太郎2号',
            'account_items' => '電車代',
            'freee_sync_status' => '0',
        ]);
        ExpenseApp::create([
            'expense_id' => '3',
            'receipt_front' => 'test_photo1',
            'receipt_back' => 'test_photo2',
            'use_date' => '2024-12-03',
            'expense_app_line_templates' => '交通費',
            'item' => '交通費',
            'purpose' => '京橋から東京駅までの乗車賃',
            'total_amount' => '500',
            'user_id' => '_9012', //userテーブルから取得予定
            'name' => '山田花子',
            'account_items' => '電車代',
            'freee_sync_status' => '0',
        ]);
    }
}
