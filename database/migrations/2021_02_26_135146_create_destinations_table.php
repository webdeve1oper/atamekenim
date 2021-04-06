<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parent_id');
            $table->string('name_ru');
            $table->string('name_kz')->nullable();
            $table->string('name_en')->nullable();
            $table->bigInteger('scenario_id')->unsigned()->nullable();
            $table->foreign('scenario_id')->references('id')->on('scenarios');
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
        Schema::dropIfExists('destinations');
    }
}
