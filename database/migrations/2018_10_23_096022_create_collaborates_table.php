<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaboratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaboratables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('collaboration_role_id')->nullable();
            $table->foreign('collaboration_role_id')->references('id')->on('collaboration_roles');
            $table->unsignedInteger('collaborate_id');
            $table->morphs('collaboratable');
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
        Schema::dropIfExists('collaborates');
    }
}
