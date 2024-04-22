<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ref', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('created_by');
            $table->boolean('activity');
            $table->string('created_at')->default(now());
            $table->string('updated_at')->default(now());
            $table->uuid('category_id');
            $table->uuid('sub_category_id');
            $table->string('photo_src')->nullable();
            $table->string('name');
            $table->uuid('chemical_class_id');
            $table->uuid('active_substance_id');
            $table->float('price')->nullable();
            $table->float('discount')->nullable();
            $table->string('deactivity_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_ref');
    }
}
