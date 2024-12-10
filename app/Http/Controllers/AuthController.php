<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ログインフォームの表示
    public function showLoginForm()
    {
        $login_check = session('user_id');
        if ($login_check) {
            return redirect('/');
        }

        //ログイン画面をviewに渡す
        return view('login');
    }

    // ログイン処理
    public function login(Request $request) //レスポンスを$requestに格納する。
    {
        \Log::info('Login attempt', [ //以下の3つの値をログに出力する
            'user_id' => $request->input('user_id'),
            'password' => $request->input('password'),
            '_token' => $request->input('_token'),
        ]);

        // dd($request->all());
        $credentials = $request->validate([ //入力する値をvalidationする
            'user_id' => 'required|string',
            'password' => 'required|string|max:255',
        ]);

        // 認証を試みる
        if (Auth::attempt($credentials)) { //もし$credentialsにログインに必要な値があれば、実行
            \Log::info('Login successful', ['user_id' => $request->input('user_id')]);
            $request->session()->regenerate(); //セッションを再生成しないとcsrf機能に引っかかるため再生成している
            // ユーザー情報をセッションに保存
            $user = Auth::user(); //ログイン認証機能からuserを取得し$userに格納

            session([ //sessionに保持
                'user_id' => $user->user_id,
                'name' => $user->name,
            ]);

            return redirect()->intended('/')->with('success', 'ログインに成功しました。');
        }
        \Log::info('Login failed', ['user_id' => $request->input('user_id')]); //ログイン失敗時　ログにuser_idを表示

        // 認証失敗時
        return back()->with('error', 'User IDまたはパスワードが正しくありません。'); //ログイン失敗時画面にエラーを表示

    }

    // ログアウト処理

    public function logout(Request $request) //ログアウトするために受け取ったユーザのパラメータを$requestで受け取る
    {
        Auth::logout(); //認証のメソッドからlogoutを実行
        $request->session()->invalidate(); //セッションに持っている認証情報を削除
        $request->session()->regenerateToken(); //元のセッションIDを削除して新規でセッションIDを発行

        return redirect('/login'); //ログアウトした情報をフロントに返す。

    }
}
