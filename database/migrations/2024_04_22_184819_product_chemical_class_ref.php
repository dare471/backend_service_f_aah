<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductChemicalClassRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_chemical_class_ref', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('NEWID()'));
            $table->text('name');
            $table->uuid('created_by');
            $table->string('created_at')->default(now());
            $table->string('updated_at')->default(now());
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_chemical_class_ref');
    }
}
