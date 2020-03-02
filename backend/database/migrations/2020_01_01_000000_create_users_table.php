<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('original')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('xsmall')->nullable();
            $table->string('small')->nullable();
            $table->string('medium')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('website')->nullable();
            $table->text('bio')->nullable();
            $table->string('status')->default('open');
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
        Schema::dropIfExists('users');
    }
}
