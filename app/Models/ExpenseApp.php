<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseApp extends Model
{
  use HasFactory;

  protected $fillable = [
      'start_date',
      'end_date',
      'item',
      'purpose',
      'total_amount',
  ];
}
