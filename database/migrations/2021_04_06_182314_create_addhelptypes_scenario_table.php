<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddhelptypesScenarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addhelptypes_to_scenarios', function (Blueprint $table) {
            $table->bigInteger('scenario_id')->unsigned();
            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
            $table->bigInteger('add_help_id')->unsigned();
            $table->foreign('add_help_id')->references('id')->on('add_help_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addhelptypes_to_scenarios');
    }
}
