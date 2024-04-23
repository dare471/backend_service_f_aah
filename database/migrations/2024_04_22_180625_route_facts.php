<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class RouteFacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_facts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('NEWID()'));
            $table->uuid('order_id');
            $table->uuid('region_to');
            $table->uuid('district_to');
            $table->text('street_to');
            $table->integer('building_number');
            $table->uuid('region_from');
            $table->uuid('district_from');
            $table->text('street_from');
            $table->float('distance')->nullable();
            $table->float('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_facts');
    }
}
