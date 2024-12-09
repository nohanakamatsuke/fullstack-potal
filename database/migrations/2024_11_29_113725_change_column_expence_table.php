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
            // 既存のカラム 'application_date' を 'use_date' に変更
            $table->renameColumn('application_date', 'use_date');
            // 新しいカラム 'total_amount' を追加
            $table->renameColumn('expense_amount', 'total_amount');

            // コメントを追加
            $table->text('use_date') // データ型も指定
                ->comment('[使用年月日] カラム名変更:application_date->use_date')
                ->change();

            // 新しいカラム 'item' を追加
            $table->text('item') //追加
                ->comment('[用途項目] カラム追加');

            // 既存のカラム 'description' を 'purpose' に変更
            $table->renameColumn('description', 'purpose');

            // コメントを追加
            $table->text('purpose')
                ->comment('[用途詳細] カラム名変更:description->purpose')
                ->change();

            // 既存のカラム 'receipt_img' を 'receipt_front' に変更
            $table->renameColumn('receipt_img', 'receipt_front');

            // コメントを追加
            $table->text('receipt_front')
                ->comment('[領収書画像(表面)] カラム名変更:receipt_img->receipt_front')
                ->change();

            // 新しいカラム 'receipt_back' を追加
            $table->text('receipt_back') //追加
                ->comment('[領収書画像(裏面)] カラム追加');

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
