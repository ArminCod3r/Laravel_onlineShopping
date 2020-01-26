<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('address_id');
            $table->integer('user_id');
            $table->integer('time');
            $table->string('date');
            $table->smallInteger('pay_type');
            $table->smallInteger('pay_status');
            $table->smallInteger('order_step');
            $table->integer('total_price');
            $table->integer('price');
            $table->string('code1')->nullable();
            $table->string('code2')->nullable();
            $table->string('order_read');
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
        Schema::dropIfExists('order');
    }
}
