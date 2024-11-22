<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller {

    public function show_home() {
        // ステータスを管理する配列
        $inHomeButton = [ '経費' => 1, '欠勤' . PHP_EOL . '遅刻' => 0, '有休' => 0, '勤務時間変更' . PHP_EOL . '休暇取得' =>0 ];
        //ヘッダー出力情報固定値
        $id = '_2222';
        $name = '釜付 野花';

        return view( 'home', compact( 'id', 'name', 'inHomeButton' ) );
    }

}
