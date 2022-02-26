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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role_code', 32);
            $table->unsignedBigInteger('dating_card_id')->nullable();
            $table->string('password');
            $table->timestamps();

            $table->foreign('role_code')->references('code')->on('user_roles');
            $table->foreign('dating_card_id')->references('id')->on('dating_cards');
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
