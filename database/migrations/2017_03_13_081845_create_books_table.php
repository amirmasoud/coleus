<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')
                  ->references('id')->on('authors')
                  ->onDelete('cascade');
            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')
                  ->references('id')->on('publishers')
                  ->onDelete('cascade');
            $table->text('description');
            $table->string('pages');
            $table->string('ISBN');
            $table->string('price');
            $table->string('year');
            $table->string('unit');
            $table->text('extra')->nullable();
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
        Schema::dropIfExists('books');
    }
}
