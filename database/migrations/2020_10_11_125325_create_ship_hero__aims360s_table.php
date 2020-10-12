<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipHeroAims360sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_hero__aims360s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('QraphQlProducts_id')->nullable();
            $table->unsignedBigInteger('Aims360Products_id')->nullable();
            $table->foreign('QraphQlProducts_id')->references('id')->on('qraph_ql_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('Aims360Products_id')->references('id')->on('aims360__products')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('ship_hero__aims360s');
    }
}
