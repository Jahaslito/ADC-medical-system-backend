<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('appointment_id');
            $table->bigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');
            $table->date('date_of_app');
            $table->string('time_of_app');
            $table->bigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->bigInteger('receptionist_id');
            $table->foreign('receptionist_id')->references('id')->on('receptionists');
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
        Schema::dropIfExists('appointments');
    }
}
