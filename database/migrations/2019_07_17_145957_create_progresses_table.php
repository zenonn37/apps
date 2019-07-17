<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('activity_id');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->unsignedInteger('excercise_id');
            $table->foreign('excercise_id')->references('id')->on('excercises')->onDelete('cascade');
            $table->integer('sets_done');
            $table->integer('reps_done');
            $table->integer('time');
            $table->boolean('to_failure')->default(0);
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
        Schema::dropIfExists('progresses');
    }
}
