<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondScenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_scenarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('fond_id')->references('id')->on('fonds')->onDelete('cascade');
            $table->bigInteger('scenario_id')->unsigned();
            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fond_scenarios');
    }
}
