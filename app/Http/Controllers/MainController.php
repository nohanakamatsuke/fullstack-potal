<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller {
    // クラスレベルで、protectedで変数を定義することで、子クラスからアクセス可能
    protected $user_id;

    protected $name;

    public function show_home( Request $request ) {
        //protectedにアクセスするために$thisを通す
        $this->user_id
        = $request->session()->get( 'user_id' );
        $this->name
        = $request->session()->get( 'name' );

        // compactは通常の変数しか扱えないので、$thisのプロパティをローカル変数に変換
        $name = $this->name;
        $user_id = $this->user_id;

        // Userテーブルからセッション情報と一致するユーザー情報を取得する
        $user = User::find( $user_id )->getAttributes();

        // role_idキーのみ取得
        $role = $user[ 'role_id' ];

        // ホームボタンの情報を、label, status, routeの配列で指定する
        $homeButton = [
            [ 'label' => '経費', 'status' => 1, 'route' => 'expense-menu', 'role' => 0 ],
            [ 'label' => '欠勤'.PHP_EOL.'遅刻', 'status' => 0, 'route' => '', 'role' => 0 ],
            [ 'label' => '有休', 'status' => 0, 'route' => '', 'role' => 0 ],
            [ 'label' => '勤務時間変更'.PHP_EOL.'休暇取得', 'status' => 0, 'route' => '', 'role' => 0 ],
            // [ 'label' => 'CSV', 'status' => 1, 'route' => 'csvMonitor', 'role' => 1 ],
        ];

        // ユーザーの権限によって、ビューに渡す配列をフィルタリングする
        $fillterdHomeButton = collect($homeButton)->filter(function($button) use($role){

          // 管理者の場合は、全てのボタンを表示
          if($role === 1){
            return true;
          };
          // それ以外は、role = 1のボタンのみ表示
          return $button['role'] === 0;
        })->all();

        //直前のページURLを取得
        $prevurl = url()->previous();

        return view( 'home', compact( 'user_id', 'name', 'fillterdHomeButton', 'role' ) );
        //フロントのhome画面に、セッションから取得した値と、各種ボタンの表示を渡す。
    }
}
