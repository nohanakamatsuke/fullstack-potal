<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class FreeeController extends MainController {
    public function index() {
    }

    /**
    * 認可コード取得のために、リダイレクト
    */

    public function redirectToFreee() {
        // Freee認証用のURL ( ログイン後に認証用URLを取得済み )
        $authorizationUrl = env( 'FREEE_CERTIFICATION_URI' );

        return redirect( "$authorizationUrl" );
    }

    /**
    * 認可コードを使って、アクセストークン取得
    */

    public function handleCallback( Request $request ) {

        //リダイレクト先のヘッダー出力用
        // 親クラスから、メソッドを呼び出す
        $this->show_home( $request );

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        //直前のページURLを取得
        $prevurl = url()->previous();

        // コールバックURLから認可コードを取得
        $authorizationCode = $request->query( 'code' );

        $tokenUrl = 'https://accounts.secure.freee.co.jp/public_api/token';
        $redirectUri = 'http://localhost/freee/callback';
        $clientId = env( 'FREEE_CLIENT_ID' );
        $clientSecret = env( 'FREEE_CLIENT_SECRET' );

        // 認可コードが存在する場合
        if ( $authorizationCode ) {
            // 認可コードをログに出力
            Log::info( 'Authorization Code:', [ 'code' => $authorizationCode ] );
        } else {
            // 認可コードが見つからない場合
            Log::info( 'Authorization code not found' );
        }

        //アクセストークン取得
        Log::info( 'Request Parameters:', [
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
            'client_id' => $clientId,
            'code' => $authorizationCode
        ] );

        try {
            // アクセストークンを取得するためのリクエスト
            $response = Http::asForm( $tokenUrl,  [
                'cache-control' => 'no-cache',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ] )->post( $tokenUrl, [
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $authorizationCode,
            ] );

            Log::info( $response );

            // レスポンスを確認
            if ( $response->successful() ) {
                $body = $response->json();
                Log::info( $body );

                // アクセストークンとリフレッシュトークンを取得
                $accessToken = $body[ 'access_token' ];
                $refreshToken = $body[ 'refresh_token' ];
                // セッションに保存
                session( [
                    'freee_access_token' => $accessToken,
                    'freee_refresh_token' => $refreshToken
                ] );

            }

        } catch ( Exception $e ) {
            Log::error( $e );
            throw $e;
        }

        // 経費メニューに戻る
        return redirect()->route( 'expense' );
    }

}
