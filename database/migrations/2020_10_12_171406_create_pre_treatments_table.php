<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_treatments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_info_id');
            $table->integer('price_id')->nullable();
            $table->string('treatment')->nullable();
            $table->string('mes')->nullable();
            $table->string('dose_time')->nullable();
            $table->string('dose_qty')->nullable();
            $table->string('dose_qty_type')->nullable();
            $table->string('dose_eat')->nullable();
            $table->string('dose_duration')->nullable()->nullable();
            $table->string('dose_duration_type')->nullable();
            $table->integer('qty')->default(1)->nullable();
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
        Schema::dropIfExists('pre_treatments');
    }
}
