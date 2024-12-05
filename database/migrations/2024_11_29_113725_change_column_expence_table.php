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
            $table->text('use_date') //変更 TEXT
                ->comment('[使用年月日] カラム名変更:application_date->use_date')
                ->after('application_date');
            $table->text('item') //追加
                ->comment('[用途項目] カラム追加');
            $table->text('purpose') //変更 TEXT
                ->comment('[用途詳細] カラム名変更:description->purpose')
                ->after('description');
            $table->text('receipt_front') //変更 TEXT
                ->comment('[領収書画像(表面)] カラム名変更:receipt_img->receipt_front')
                ->after('receipt_img');
            $table->text('receipt_back') //追加
                ->comment('[領収書画像(裏面)] カラム追加');
            $table->text('total_amount') //追加
                ->comment('[合計金額] カラム追加');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_app', function (Blueprint $table) {
            //追加したカラム、変更したカラムを追加する。
            $table->dropColumn('use_date');
            $table->dropColumn('item');
            $table->dropColumn('purpose');
            $table->dropColumn('receipt_front');
            $table->dropColumn('receipt_back');
            $table->dropColumn('total_amount');
        });
    }
};
