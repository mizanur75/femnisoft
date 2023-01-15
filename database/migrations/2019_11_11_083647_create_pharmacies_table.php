<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('logo')->nullable();
            $table->string('slogan')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->float('tax')->default(0);
            $table->float('discount')->default(0);
            $table->string('open_time')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('payment')->default(0);
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
        Schema::dropIfExists('pharmacies');
    }
}
