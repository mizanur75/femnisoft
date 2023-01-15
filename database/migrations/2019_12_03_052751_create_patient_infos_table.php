<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientInfosTable extends Migration
{

    public function up()
    {
        Schema::create('patient_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('patient_id');
            $table->string('blood_presure')->nullable();
            $table->string('dbp')->nullable();
            $table->string('mem_type')->nullable();
            $table->string('edu')->nullable();
            $table->string('blood_sugar')->nullable();
            $table->string('pulse')->nullable();
            $table->string('temp')->nullable();
            $table->string('diabeties')->nullable();
            $table->string('hp')->nullable();
            $table->string('ihd')->nullable();
            $table->string('strk')->nullable();
            $table->string('copd')->nullable();
            $table->string('cancer')->nullable();
            $table->string('ckd')->nullable();
            $table->boolean('anemia')->nullable()->default(0);
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('oxygen')->nullable();
            $table->boolean('edima')->default(0);
            $table->string('bmi')->nullable();
            $table->string('heart')->nullable();
            $table->string('lungs')->nullable();
            $table->boolean('jaundice')->default(0);
            $table->string('salt')->nullable();
            $table->string('smoke')->nullable();
            $table->string('smoking')->nullable();
            $table->string('predate')->nullable();
            $table->string('predochos')->nullable();
            $table->string('presymptom')->nullable();
            $table->string('prediagnosis')->nullable();
            $table->string('preinvestigation')->nullable();
            $table->string('preinvresult')->nullable();
            $table->string('pretreatment')->nullable();
            $table->string('followinvestigation')->nullable();
            $table->string('firstfollowinvestigation')->nullable();
            $table->text('others')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_infos');
    }
}
