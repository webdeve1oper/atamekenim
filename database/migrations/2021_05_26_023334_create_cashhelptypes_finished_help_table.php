<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashhelptypesFinishedHelpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashhelptypes_finished_help', function (Blueprint $table) {
            $table->bigInteger('finished_help_id')->unsigned();
            $table->foreign('finished_help_id')->references('id')->on('finished_helps')->onDelete('cascade');
            $table->bigInteger('cash_help_id')->unsigned();
            $table->foreign('cash_help_id')->references('id')->on('cash_help_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashhelptypes_finished_help');
    }
}
