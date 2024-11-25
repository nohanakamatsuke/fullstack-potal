<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    // ログインフォームの表示

    public function showLoginForm() {
        return view( 'login' );
    }

    // ログイン処理

    public function login( Request $request ) {
        \Log::info( 'Login attempt', [
            'user_id' => $request->input( 'user_id' ),
            'password' => $request->input( 'password' ),
            '_token' => $request->input( '_token' ),
        ] );

        // dd( $request->all() );
        $credentials = $request->validate( [
            'user_id' => 'required|string',
            'password' => 'required|string',
        ] );
        // 認証を試みる
        if ( Auth::attempt( $credentials ) ) {
            \Log::info( 'Login successful', [ 'user_id' => $request->input( 'user_id' ) ] );
            $request->session()->regenerate();
            // ユーザー情報をセッションに保存
            $user = Auth::user();

            session( [
                'user_id' => $user->user_id,
                'name' => $user->name
            ] );
            return redirect()->intended( '/' )->with( 'success', 'ログインに成功しました。' );
        }
        \Log::info( 'Login failed', [ 'user_id' => $request->input( 'user_id' ) ] );

        // 認証失敗時
        return back()->with( 'error', 'User IDまたはパスワードが正しくありません。' );
    }

    public function testSession( Request $request ) {
        if ( ! $request->session()->has( 'test_key' ) ) {
            $request->session()->put( 'test_key', 'This is a test value' );

            return response( 'セッションに値を保存しました' );
        }

        return response( 'セッションから値を取得: '.$request->session()->get( 'test_key' ) );
    }

    // ログアウト処理

    public function logout( Request $request ) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect( '/login' );

    }
}
