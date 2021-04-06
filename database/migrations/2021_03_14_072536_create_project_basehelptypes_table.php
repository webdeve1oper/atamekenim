<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectBasehelptypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_basehelptypes', function (Blueprint $table) {
            $table->bigInteger('base_help_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->foreign('base_help_id')->references('id')->on('base_help_types')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('fonds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_basehelptypes');
    }
}
