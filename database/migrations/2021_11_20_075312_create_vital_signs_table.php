<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->bigIncrements('vital_signs_id');

            $table->bigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->integer('weight');
            $table->double('temperature', 8, 2);
            $table->string('blood_pressure');
            $table->integer('height');
            $table->string('pulse_rate')->nullable();
            $table->double('BMI', 8, 2);
            
            $table->bigInteger('lab_test_id');
            $table->foreign('lab_test_id')->references('lab_test_id')->on('lab_results');

            $table->bigInteger('staff_id');
            $table->foreign('staff_id')->references('nurses')->on('id');

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
        Schema::dropIfExists('vital_signs');
    }
}
