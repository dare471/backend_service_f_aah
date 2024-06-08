<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devivery_order', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('NEWID()'));
            $table->text('period');
            $table->string('synonym_order');
            $table->string('type_order');
            $table->string('order_guid');
            $table->string('name');
            $table->string('state');
            $table->string('date_events');
            $table->string('processing_rate');
            $table->string('synonym_shipment_order');
            $table->string('type_shipment_order');
            $table->string('shipment_order');
            $table->text('short_url');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devivery_order');
    }
}
