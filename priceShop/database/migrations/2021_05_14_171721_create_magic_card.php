<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagicCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magic_card', function (Blueprint $table) {
            $table->id('id')->autoIncrement();
            $table->string('name');
            $table->unsignedBigInteger('card_kingdom_id');
            $table->foreign('card_kingdom_id')->references('id')->on('card_kingdom');
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
        Schema::dropIfExists('magic_card');
    }
}
