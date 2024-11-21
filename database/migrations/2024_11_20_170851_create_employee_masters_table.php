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
        Schema::create('employee_masters', function (Blueprint $table) {
            $table->id('employee_id');
            $table->integer('user_auth_id');
            $table->integer('role_id');
            $table->string('name');
            $table->date('birth_day');
            $table->date('first_day');
            $table->string('position_name');
            $table->text('position_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_masters');
    }
};
