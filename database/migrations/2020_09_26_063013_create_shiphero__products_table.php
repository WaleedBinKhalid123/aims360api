<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipheroProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiphero__products', function (Blueprint $table) {
            $table->id();
            $table->string('style');
            $table->string('color');
            $table->string('sizenum');
            $table->string('sizedesc');
            $table->string('SKU')->unique();
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
        Schema::dropIfExists('shiphero__products');
    }
}
