<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParsingStatGov extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parsing_stat_gov', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('NEWID()'));
            $table->string('bin');
            $table->text('fullName');
            $table->text('nameOrg');
            $table->string('okedCode');
            $table->text('okedName');
            $table->string('secondOkeds')->nullable();
            $table->float('krpCode');
            $table->text('krpName');
            $table->float('economicSectorCode');
            $table->text('economicSectorName');
            $table->text('registeredAddress');
            $table->text('typeOrg');
            $table->string('registerDate');
            $table->float('cfoCode')->nullable();
            $table->string('cfoName');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parsing_stat_gov');
    }
}
