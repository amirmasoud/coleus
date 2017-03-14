<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_movement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')
                  ->references('id')->on('authors')
                  ->onDelete('cascade');
            $table->integer('movement_id')->unsigned();
            $table->foreign('movement_id')
                  ->references('id')->on('movements')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('author_movement');
    }
}
