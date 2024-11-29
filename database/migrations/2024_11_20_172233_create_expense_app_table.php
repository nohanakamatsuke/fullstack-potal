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
        Schema::create('expense_app', function (Blueprint $table) {
            $table->id('expense_id'); //経費申請id
            $table->integer('user_id'); //社員情報　外部キー
            $table->date('application_date')->nullable(); //申請日
            $table->integer('expense_amount')->nullable(); //経費申請額
            $table->text('description'); //申請内容
            $table->text('receipt_img'); //領収書画像
            $table->string('expense_app_line_templates', 50); //経費科目
            $table->string('account_items', 50); //勘定科目
            $table->integer('freee_sync_status'); //Freee人事連携状況
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_app');
    }
};
