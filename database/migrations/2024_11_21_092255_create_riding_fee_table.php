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
        Schema::create('riding_fee', function (Blueprint $table) {
            $table->id('ride_fee_id');
            $table->integer('employee_id'); //社員情報　外部キー
            $table->string('nearest_station', 225); //最寄り駅
            $table->string('work_nearest_station', 255); //出金先最寄り駅
            $table->integer('fare'); //最寄り駅-出金先
            $table->string('route', 255); //路線名
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riding_fee');
    }
};
