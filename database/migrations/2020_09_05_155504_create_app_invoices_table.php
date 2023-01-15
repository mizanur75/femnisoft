<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('patient_request_id');
            $table->integer('patient_id');
            $table->integer('doctor_id');
            $table->integer('amount');
            $table->integer('pay_amount')->default(5)->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('app_invoices');
    }
}
