<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('expense_app', function (Blueprint $table) {
      $table->string('title', 50)
        ->comment('[申請タイトル] カラム追加')
        ->after('item');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('expense_app', function (Blueprint $table) {
      $table->dropColumn('title');
    });
  }
};
