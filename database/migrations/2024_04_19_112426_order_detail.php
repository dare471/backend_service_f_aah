<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->boolean('sign_in');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->uuid('product_id');
            $table->float('count');
            $table->float('price');
            $table->boolean('actual_price');
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->float('recomendated_price');
            $table->uuid('delivery_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
}
