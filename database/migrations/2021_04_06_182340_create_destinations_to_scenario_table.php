<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsToScenarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations_to_scenarios', function (Blueprint $table) {
            $table->bigInteger('scenario_id')->unsigned();
            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
            $table->bigInteger('destination_id')->unsigned();
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinations_to_scenarios');
    }
}
