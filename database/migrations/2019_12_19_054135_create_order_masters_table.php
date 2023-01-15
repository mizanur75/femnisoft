<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',20)->unique();
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->float('total_amount',20);
            $table->float('given_amount',20);
            $table->integer('payment_method');
            $table->string('comments')->nullable();
            $table->string('tax')->default(0);
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
        Schema::dropIfExists('order_masters');
    }
}
