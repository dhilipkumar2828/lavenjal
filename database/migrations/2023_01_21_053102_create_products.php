<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image');
            $table->longText('description');
            $table->string('size');
            $table->enum('type',['jar','bottle']);
            $table->integer('quantity_per_case');
            $table->integer('customer_price');
            $table->string('retailer_price');
            $table->enum('is_returnable',['yes','no']);
            $table->integer('deposit_amount');
            $table->string('status');
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
        Schema::dropIfExists('products');
    }
};
