<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('company_id')->nullable();
            $table->integer('generic_id');
            $table->string('name');
            $table->string('brand_name')->nullable();
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('disease')->nullable();
            $table->string('side_effect')->nullable();
            $table->string('company')->nullable();
            $table->string('doses')->nullable();
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
        Schema::dropIfExists('medicines');
    }
}
