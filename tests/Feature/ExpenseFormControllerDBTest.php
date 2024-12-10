<?php

namespace Tests\Feature;

use App\Models\ExpenseApp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ExpenseFormControllerDBTest extends TestCase
{


  /**
   * 経費申請データがデータベースに保存されているかをテスト
   */
  public function test_expense_data_is_saved_in_database()
  {
    // テストユーザーの作成と認証
    $user = User::factory()->create();
    $this->actingAs($user)->withSession([
      'user_id' => 'user1234',
    ]);

    // セッションデータを設定
    Session::start(); // 必要ならセッションをスタート

    session([
      'user_id' => [1234],
      'use_date' => ['2024-12-01'],
      'purpose' => ['通勤'],
      'receipt_front' => ['path/to/fake_receipt_front.jpg'],
      'expense_app_line_templates' => ['default'],
      'account_items' => ['default'],
      'freee_sync_status' => [0],
      'item' => ['交通費(定期)'],
      'receipt_back' => ['path/to/fake_receipt_back.jpg'],
      'total_amount' => ['1500'],


    ]);

    // POSTリクエストのデータを準備
    $data = [];

    // フォーム送信をシミュレート
    $response = $this->post('/expense_store', $data);

    // ステータスコードが302系(リダイレクト)であることを確認
    $response->assertStatus(302);

    // データベースにデータが保存されていることを確認
    $this->assertDatabaseHas('expense_app', [
      //'user_id' => $user->id,
      'item' => '交通費(定期)',
      'purpose' => '通勤',
      // 'total_amount' => 1500,
      // 'receipt_img' => 'path/to/fake_receipt_front.jpg,path/to/fake_receipt_back.jpg',
      // 'expense_app_line_templates' => 'default_template',
      // 'account_items' => 'default_account',
      // 'freee_sync_status' => 0,
    ]);
  }
}
