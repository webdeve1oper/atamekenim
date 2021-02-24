<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondAddhelpstypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_addhelptypes', function (Blueprint $table) {
            $table->bigInteger('add_help_id')->unsigned();
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('add_help_id')->references('id')->on('add_help_types')->onDelete('cascade');
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
        Schema::dropIfExists('fond_addhelptypes');
    }
}
