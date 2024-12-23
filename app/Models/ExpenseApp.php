<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseApp extends Model
{
  use HasFactory;

  protected $table = 'expense_app';

  protected $fillable = [
    'user_id', //Userからの外部キー
    'name', //Userからの外部キー
    'use_date', // 修正されたカラム名
    'expense_amount',
    'purpose', // 修正されたカラム名
    'item',
    'title',
    'receipt_front', // 修正されたカラム名
    'receipt_back',
    'total_amount',
    'expense_app_line_templates',
    'account_items',
    'freee_sync_status',
  ];

  public function user()  // 単数形に修正
  {
    return $this->belongsTo(User::class, 'user_id', 'user_id');
  }
}
