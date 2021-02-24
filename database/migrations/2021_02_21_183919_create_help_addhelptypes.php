<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpAddhelptypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_addhelptypes', function (Blueprint $table) {
            $table->bigInteger('add_help_id')->unsigned();
            $table->bigInteger('help_id')->unsigned();
            $table->foreign('help_id')->references('id')->on('helps')->onDelete('cascade');
            $table->foreign('add_help_id')->references('id')->on('add_help_types')->onDelete('cascade');
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
        Schema::dropIfExists('help_addhelptypes');
    }
}
