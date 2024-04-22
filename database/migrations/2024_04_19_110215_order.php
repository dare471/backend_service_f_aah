<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('status');
            $table->integer('cretated_by');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->uuid('client_id');
            $table->boolean('main_order')->default(true);
            $table->uuid('children_order')->nullable();
            $table->uuid('order_detail');
            $table->boolean('delivery_needed')->default(false);
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
        Schema::dropIfExists('order');
    }
}
