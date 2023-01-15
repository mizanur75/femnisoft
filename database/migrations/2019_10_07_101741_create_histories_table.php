<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('user_id');
            $table->integer('patient_id');
            $table->integer('patient_info_id')->nullable();
            $table->string('heart')->nullable();
            $table->string('lungs')->nullable();
            $table->integer('doctor_id');
            $table->text('cc')->nullable();
            $table->text('investigation')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('sec_diagnosis')->nullable();
            $table->text('predochos')->nullable();
            $table->text('pretreatment')->nullable();
            $table->text('preinvestigation')->nullable();
            $table->text('test')->nullable();
            $table->text('suggested_test')->nullable();
            $table->text('advices')->nullable();
            $table->string('next_meet')->nullable();
            $table->text('follow_up')->nullable();
            $table->text('referred')->nullable();
            $table->text('referred_by')->nullable();
            $table->text('comment')->nullable();
            $table->string('age')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('histories');
    }
}
