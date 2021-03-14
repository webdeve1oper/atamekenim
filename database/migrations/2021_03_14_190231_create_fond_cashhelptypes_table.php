<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondCashhelptypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_cashhelptypes', function (Blueprint $table) {
            $table->bigInteger('cash_help_id')->unsigned();
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('cash_help_id')->references('id')->on('cash_help_types')->onDelete('cascade');
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
        Schema::dropIfExists('fond_cashhelptypes');
    }
}
