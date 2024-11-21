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
        Schema::create('freee_login_users', function (Blueprint $table) {
            $table->id('freee_login_id');
            $table->integer('employee_id');
            $table->string('freee_login_mail');
            $table->string('freee_password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freee_login_users');
    }
};
