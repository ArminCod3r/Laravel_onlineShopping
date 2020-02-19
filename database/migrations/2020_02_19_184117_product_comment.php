<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_comment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->string('subject');
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->text('comment_text')->nullable();
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
        Schema::dropIfExists('product_comment');
    }
}
