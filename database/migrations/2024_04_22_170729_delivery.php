<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Delivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devlivery_facts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('created_at')->now();
            $table->string('updated_at')->now();
            $table->uuid('order_id');
            $table->uuid('transport_id');
            $table->uuid('driver_id');
            $table->uuid('route_id');
            $table->uuid('warehouse_id');
            $table->float('quantity');
            $table->float('weight');
            $table->float('volume');
            $table->uuid('delivery_status');
            $table->float('shipping_cost');
            $table->string('expected_delivery_date');
            $table->string('actual_delivery_date');
            $table->text('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devlivery_facts');
    }
}
