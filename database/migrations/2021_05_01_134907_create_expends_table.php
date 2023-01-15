<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cost_name_id');
            $table->string('description');
            $table->string('amount');
            $table->string('date');
            $table->string('create_user_id');
            $table->string('update_user_id');
            $table->string('create_user_ip');
            $table->string('update_user_ip');
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
        Schema::dropIfExists('expends');
    }
}
