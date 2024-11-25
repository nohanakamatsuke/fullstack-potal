<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller {

    public function show_home( Request $request ) {
        // ステータスを管理する配列
        $inHomeButton = [ '経費' => 1, '欠勤' . PHP_EOL . '遅刻' => 0, '有休' => 0, '勤務時間変更' . PHP_EOL . '休暇取得' =>0 ];

        $user_id = $request->session()->get( 'user_id' );
        $name = $request->session()->get( 'name' );

        return view( 'home', compact( 'user_id', 'name', 'inHomeButton' ) );
    }

}
