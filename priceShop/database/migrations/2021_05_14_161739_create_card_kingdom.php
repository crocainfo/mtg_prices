<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardKingdom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_kingdom', function (Blueprint $table) {
            $table->id('id')->autoIncrement();
            $table->integer('price_nm')->nullable();
            $table->integer('price_ex')->nullable();
            $table->integer('price_nm_foil')->nullable();
            $table->integer('price_ex_foil')->nullable();
            $table->string('link_to_webpage')->nullable();
            $table->string('link_to_image')->nullable();

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
        Schema::dropIfExists('card_kingdom');
    }
}
