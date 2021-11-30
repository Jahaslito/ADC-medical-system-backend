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

            $table->string('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');

            $table->integer('weight');
            $table->string('blood_pressure');
            $table->integer('height');
            $table->string('pulse_rate')->nullable();
            $table->double('BMI', 8, 2);
            
            $table->integer('lab_test_id')->nullable();
            $table->foreign('lab_test_id')->references('lab_test_id')->on('lab_results');

            $table->string('staff_id');

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
