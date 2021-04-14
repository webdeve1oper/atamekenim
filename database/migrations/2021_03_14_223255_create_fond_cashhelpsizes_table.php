<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondCashhelpsizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_cashhelpsize', function (Blueprint $table) {
            $table->bigInteger('cash_help_size_id')->unsigned();
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('cash_help_size_id')->references('id')->on('cash_help_size')->onDelete('cascade');
            $table->foreign('fond_id')->references('id')->on('fonds')->onDelete('cascade');
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
        Schema::dropIfExists('fond_cashhelpsize');
    }
}
