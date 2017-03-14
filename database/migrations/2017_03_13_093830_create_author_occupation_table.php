<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorOccupationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_occupation', function (Blueprint $table) {
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')
                  ->references('id')->on('authors')
                  ->onDelete('cascade');
            $table->integer('occupation_id')->unsigned();
            $table->foreign('occupation_id')
                  ->references('id')->on('occupations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_occupation');
    }
}
