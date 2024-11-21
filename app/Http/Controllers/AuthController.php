<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {
    public function login( Request $request ) {
        $credentials = $request->only( 'user_id', 'password' );

        if ( auth()->attempt( $credentials ) ) {
            // ログイン成功時の処理
            return redirect()->route( 'home' )->with( 'success', 'ログインに成功しました！' );
        }

        // ログイン失敗時の処理
        return redirect()->back()->with( 'error', '社員IDまたはパスワードが間違っています。' );
    }
}
