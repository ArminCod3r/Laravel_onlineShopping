<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmazingProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazing_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('short_title');
            $table->string('long_title');
            $table->text('description');
            $table->integer('price');
            $table->integer('price_discounted');
            $table->integer('product_id');
            $table->integer('time_amazing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazing_products');
    }
}
