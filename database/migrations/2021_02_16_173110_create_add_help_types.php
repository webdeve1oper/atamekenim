<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddHelpTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_help_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('base_help_types_id')->references('id')->on('base_help_types')->nullable();;
            $table->string('name_ru');
            $table->string('name_kz')->nullable();
            $table->bigInteger('scenario_id');
            $table->foreign('scenario_id')->references('id')->on('scenarios')->nullable();
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
        Schema::dropIfExists('add_help_types');
    }
}
