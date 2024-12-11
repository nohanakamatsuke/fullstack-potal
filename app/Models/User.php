<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use Notifiable;

    // 主キーの設定
    protected $primaryKey = 'user_id';

    // 主キーが自動増分ではないことを明示
    public $incrementing = false;

    // 主キーの型をstringに設定
    protected $keyType = 'string';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'user_id',
        'password',
        'role_id',
        'name',
    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function expenceApps() //関数名は単数形がベスト
    {
        // UserモデルからExpenseAppモデルへの1対多のリレーションを定義
        // nameカラムを使用して関連付け
        return $this->hasMany(ExpenseApp::class, 'user_id', 'user_id');
    }
}
