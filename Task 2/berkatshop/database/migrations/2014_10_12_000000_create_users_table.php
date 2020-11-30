<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('username', 50)->unique(); //USERNAME ACCOUNT
            $table->string('email')->unique(); //EMAIL ACCOUNT
            $table->string('phone')->unique(); //TELF ACCOUNT
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //PASS ACCOUNT
            $table->string('role', 10);
            $table->integer('level');
            $table->integer('status'); // STATUS AKTIF AKUN
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
