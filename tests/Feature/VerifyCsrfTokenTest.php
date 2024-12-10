<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifyCsrfTokenTest extends TestCase
{
  /**
   * 有効なCSRFトークンを使用した場合のテスト
   */
  public function testExpenseFormSubmitWithValidCsrfToken()
  {
    // CSRFトークンを生成
    $token = csrf_token();

    dd($token);

    // フォームデータ
    $data = [
      '_token' => $token,
      'date' => ['2024-12-01'],
      'item' => ['お金'],
      'purpose' => ['テスト'],
      'total_amount' => ['3000'],
    ];

    // POSTリクエストを送信
    $response = $this->post('/expense-submit', $data);

    dd($token, $response);

    // ステータスコード200を確認
    $response->assertStatus(200);

    // セッションデータを直接取得
    $sessionData = session('form_input');

    // セッションデータが正しいことを確認
    $this->assertEquals($data, $sessionData);
  }

  /**
   * 無効なCSRFトークンを使用した場合のテスト
   */
  // public function testExpenseFormSubmitWithNotValidCsrfToken()
  // {
  //   // CSRFトークンを生成
  //   $token = csrf_token();

  //   // フォームデータ
  //   $data = [
  //     '_token' => $token,
  //     'date' => ['2024-12-01'],
  //     'item' => ['お金'],
  //     'purpose' => ['テスト'],
  //     'total_amount' => ['3000'],
  //   ];

  //   // POSTリクエストを送信
  //   $response = $this->post('/expense-submit', $data);

  //   // ステータスコード200を確認
  //   $response->assertStatus(200);

  //   // セッションデータを直接取得
  //   $sessionData = session('form_input');

  //   // セッションデータが正しいことを確認
  //   $this->assertEquals($data, $sessionData);
  // }
}
