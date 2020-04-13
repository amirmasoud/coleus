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
            $table->text('description');
            $table->string('original')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('xsmall')->nullable();
            $table->string('small')->nullable();
            $table->string('medium')->nullable();
            $table->string('website')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('sticky')->default(false);
            $table->unsignedInteger('order')->default(0);
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
