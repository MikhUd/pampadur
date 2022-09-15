<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('about');
            $table->integer('gender');
            $table->integer('seeking_for');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('dating_cards');
    }
}
