<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHierarchieFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hierarchie_filter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('ename');
            $table->integer('parent_id');
            $table->integer('category_id');
            $table->integer('filled');
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
        Schema::dropIfExists('hierarchie_filter');
    }
}
