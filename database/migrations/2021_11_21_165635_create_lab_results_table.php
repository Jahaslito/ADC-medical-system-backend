<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->bigIncrements('lab_test_id');

            $table->bigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');
            
            // $table->string('results');
            $table->string('test_type');
            
            $table->bigInteger('lab_result_id');
            $table->foreign('lab_result_id')->references('lab_result_id')->on('lab_result_types');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *string
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_results');
    }
}
