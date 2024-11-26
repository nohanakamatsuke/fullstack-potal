<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function show_home(Request $request)
    {
        // ステータスを管理する配列
        $inHomeButton = ['経費' => 1, '欠勤'.PHP_EOL.'遅刻' => 0, '有休' => 0, '勤務時間変更'.PHP_EOL.'休暇取得' => 0];

        $user_id = $request->session()->get('user_id'); //user_idをセッション情報から取得し、user_idに格納する
        $name = $request->session()->get('name'); //nameをセッション情報から取得し、nameに格納する。

        return view('home', compact('user_id', 'name', 'inHomeButton')); //フロントのhome画面に、セッションから取得した値と、各種ボタンの表示を渡す。
    }
}
