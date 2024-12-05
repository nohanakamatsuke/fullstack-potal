<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// パスワードハッシュ化用

class UserSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        // サンプルユーザー1
        User::create( [
            'user_id' => 'user1234', // ユーザーID
            'name' => 'テストユーザー1',
            'phone_number' => '0000000000',
            'email' => 'test1@example.com',
            'role_id' => '1',
            'password' => Hash::make('password'), // パスワードをハッシュ化
        ]);
        // サンプルユーザー2
        User::create([

            'user_id' => 'user5678', // ユニークなユーザーID
            'name' => 'テストユーザー2',
            'phone_number' => '1111111111',
            'email' => 'test2@example.com',
            'role_id' => '2',
            'password' => Hash::make('password'), // パスワードをハッシュ化
        ]);
    }
}
