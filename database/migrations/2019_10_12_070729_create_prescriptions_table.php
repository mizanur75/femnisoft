<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_id');
            $table->integer('patient_info_id')->nullable();
            $table->integer('doctor_id');
            $table->integer('history_id');
            $table->integer('price_id');
            $table->string('mes');
            $table->string('dose_time');
            $table->string('dose_qty');
            $table->string('dose_qty_type');
            $table->string('dose_eat');
            $table->string('dose_duration')->nullable();
            $table->string('dose_duration_type');
            $table->integer('qty')->default(1);
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
        Schema::dropIfExists('prescriptions');
    }
}
