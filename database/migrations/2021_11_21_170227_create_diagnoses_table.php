<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->bigIncrements('diagnosis_id');

            $table->string('staff_id');

            $table->string('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->string('diagnosis');
            $table->string('prescription_id');
            $table->foreign('prescription_id')->references('prescription_id')->on('prescriptions');

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
        Schema::dropIfExists('diagnoses');
    }
}
