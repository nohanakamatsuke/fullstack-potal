<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FreeeController extends Controller
{
  public function index() {}

  /**
   * 認可コード取得のために、リダイレクト
   */
  public function redirectToFreee()
  {
    // Freee認証用のURL (ログイン後に認証用URLを取得済み)
    $authorizationUrl = env('FREEE_CERTIFICATION_URI');

    return redirect("$authorizationUrl");
  }

  /**
   * 認可コードを取得してログ出力
   */
  public function handleCallback(Request $request)
  {
    // コールバックURLから認可コードを取得
    $authorizationCode = $request->query('code');

    // 認可コードが存在する場合
    if ($authorizationCode) {
      // 認可コードをログに出力
      Log::info('Authorization Code:', ['code' => $authorizationCode]);
    } else {
      // 認可コードが見つからない場合
      Log::info('Authorization code not found');
    }
  }

  /**
   * アクセストークン初回取得
   */
  public function getAccessToken(Request $request)
  {
    // 必要な変数を定義
    $tokenUrl = "https://accounts.secure.freee.co.jp/public_api/token"; //Access Token URLにリクエストを送信する
    $redirectUri = urlencode("http://localhost");
    $clientId = env('FREEE_CLIENT_ID');
    $clientSecret = env('FREEE_CLIENT_SECRET');
    $code = "797953a2e8c66e9309fede3c3c246de7caf9fa61e643a695255133da1dec7081";

    try {
      // アクセストークンを取得するためのリクエスト
      $response = Http::withHeaders([
        'cache-control' => 'no-cache',
        'Content-Type' => 'application/x-www-form-urlencoded'
      ])->post($tokenUrl, [
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirectUri,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'code' => $code,
      ]);
      Log::info($response);
      // レスポンスを確認
      if ($response->successful()) {
        $body = $response->json();
        Log::ingo($body);

        // // アクセストークンとリフレッシュトークンを取得
        // $accessToken = $body['access_token'];
        // $refreshToken = $body['refresh_token'];

        // // 必要であればデータベースに保存
        // // e.g., DB::table('tokens')->insert([...]);
        // Log::info($accessToken);

        // return response()->json([
        //   'message' => 'Access token retrieved successfully.',
        //   'access_token' => $accessToken,
        //   'refresh_token' => $refreshToken,
        // ]);
        // } else {
        //   return response()->json([
        //     'message' => 'Failed to retrieve access token.',
        //     'error' => $response->json(),
        //   ], $response->status());
      }
    } catch (Exception $e) {
      Log::error($e);
      throw $e;
    }
  }
}
