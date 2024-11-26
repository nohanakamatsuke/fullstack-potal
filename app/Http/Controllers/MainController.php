<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller {

    // クラスレベルで、protectedで変数を定義することで、子クラスからアクセス可能
    protected $user_id;
    protected $name;

    public function show_home( Request $request ) {

        //protectedにアクセスするために$thisを通す
        $this -> user_id
        = $request->session()->get( 'user_id' );
        $this -> name
        = $request->session()->get( 'name' );

        // ホームボタンの情報を、label, status, routeの配列で指定する
        $inHomeButton = [
            [ 'label' =>'経費', 'status' => 1, 'route' => 'expense-menu' ],
            [ 'label' => '欠勤' . PHP_EOL . '遅刻', 'status' => 0, 'route' => '' ],
            [ 'label' =>'有休', 'status' => 0, 'route' => '' ],
            [ 'label' =>'勤務時間変更' . PHP_EOL . '休暇取得', 'status' => 0, 'route' => '' ],
        ];

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        //直前のページURLを取得
        $prevurl = url()->previous();

        return view( 'home', compact( 'user_id', 'name', 'inHomeButton' ) );
        //フロントのhome画面に、セッションから取得した値と、各種ボタンの表示を渡す。
    }
}
