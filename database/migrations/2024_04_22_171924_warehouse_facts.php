<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WarehouseFacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_facts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('warehouse_id');
            $table->string('created_at')->default(now());
            $table->string('updated_at')->default(now());
            $table->uuid('product_id');
            $table->float('quantity');
            $table->uuid('transaction_type');
            $table->uuid('operator_id');
            $table->float('price');
            $table->uuid('customer_id');
            $table->uuid('status');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_facts');
    }
}
