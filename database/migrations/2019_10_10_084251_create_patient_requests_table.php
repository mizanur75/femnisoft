<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->integer('patient_info_id')->nullable();
            $table->string('appoint_date');
            $table->boolean('is_transfer')->default(0);
            $table->boolean('accept')->default(0);
            $table->boolean('done')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('is_delete')->default(0);
            $table->integer('serial_no')->nullable();
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
        Schema::dropIfExists('patient_requests');
    }
}
