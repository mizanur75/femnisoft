<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('centre_patient_id')->unique();
            $table->string('reg_mem')->nullable();
            $table->string('name');
            $table->string('age');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('marital_status');
            $table->boolean('gender');
            $table->integer('address_id');
            $table->string('blood_group')->nullable();
            $table->string('blood_presure')->nullable();
            $table->string('blood_sugar')->nullable();
            $table->string('pulse')->nullable();
            $table->text('injury')->nullable();
            $table->string('image')->default('default.png');
            $table->string('slug');
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
        Schema::dropIfExists('patients');
    }
}
