<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_id');
            $table->integer('medicine_id');
            $table->integer('category_id');
            $table->integer('price_id');
            $table->integer('qty');
            $table->integer('piece_qty')->default(1);
            $table->integer('uom_id');
            $table->float('price',20);
            $table->float('dis',20)->default(0);
            $table->float('linetotal',20);
            $table->string('expire_date')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
}
