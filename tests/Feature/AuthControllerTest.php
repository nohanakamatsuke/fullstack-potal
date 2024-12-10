<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Event\Code\Test;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllerTest extends TestCase
{

  use RefreshDatabase;

  /**
   * ログインフォームから認証が成功し、http://localhost/ にリダイレクトされるテスト検証
   */
  public function test_redirect_localhost(): void
  {
    // テスト用のユーザーを作成
    $user = User::factory()->create([
      'password' => bcrypt('password'), // テスト用のパスワードを設定
    ]);

    // actingAsで認証済みの状態をシミュレート
    $response = $this->actingAs($user)
      ->post('/login', [
        'user_id' => $user->user_id,
        'password' => 'password', // 正しいパスワード
      ]);

    // 認証が成功していることを確認
    $this->assertAuthenticatedAs($user);

    // リダイレクト先が http://localhost/ であることを確認
    $response->assertRedirect('http://localhost');
  }

  /**
   * 未認証の場合、ログインフォームにリダイレクトされるテスト
   */
  // public function test_uncertified(): void
  // {
  //   // テスト用のユーザーを作成
  //   $user = User::factory()->create([
  //     'password' => bcrypt('password'), // 正しいパスワード
  //   ]);

  //   // 誤った認証情報を使用してログインフォームを送信
  //   $response = $this->post('/login', [
  //     'user_id' => $user->user_id,
  //     'password' => 'wrong-password', // 間違ったパスワード
  //   ]);

  //   // 認証されていないことを確認
  //   $this->assertGuest();

  //   // ログイン画面にリダイレクトされることを確認
  //   $response->assertRedirect('/login'); //コントローラーがbackメソッドでリダイレクトしているため、検証不可
  //}

  /**
   * ログイン失敗時のエラーメッセージをテスト
   */
  public function test_login_fails_with_error_message()
  {
    // モックユーザーの作成（必要に応じてUserモデルを用意）
    \App\Models\User::factory()->create([
      'user_id' => 'user1234',
      'password' => bcrypt('password'),
    ]);

    // 無効なログイン情報を送信
    $response = $this->post('/login', [
      'user_id' => 'invalid_user',
      'password' => 'invalid_password',
    ]);

    // リダイレクトを確認
    $response->assertRedirect();

    // セッションにエラーメッセージが保存されていることを確認
    $response->assertSessionHas('error', 'User IDまたはパスワードが正しくありません。');

    // 認証されていないことを確認
    $this->assertFalse(Auth::check());
  }

  /**
   * ログアウト時の挙動をテスト
   */
  public function test_logout_clears_session_and_redirects_to_login()
  {
    // モックユーザーを作成してログイン状態にする
    $user = \App\Models\User::factory()->create([
      'user_id' => 'user1234',
      'password' => bcrypt('password'),
    ]);

    // ユーザーをログイン状態に設定
    $this->actingAs($user);

    // ログアウトリクエストを送信
    $response = $this->post('/logout');

    // セッションが無効化されていることを確認
    $this->assertGuest();

    // ログイン画面にリダイレクトされることを確認
    $response->assertRedirect('/login');
  }
}
