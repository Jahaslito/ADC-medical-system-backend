<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('video_id');
            $table->bigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');
            $table->bigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->date('date_of_meet');
            $table->string('time_of_meet');
            $table->string('video_link');
            $table->string('status');
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
        Schema::dropIfExists('videos');
    }
}
