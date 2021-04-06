<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('city_id')->nullable();
            $table->foreign('city_id')->references('city_id')->on('cities');
            $table->bigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('region_id')->on('regions');
            $table->text('body');
            $table->enum('status', ['moderate','wait', 'cancel', 'process','finished'])->default('moderate');
            $table->date('date_fond_start')->nullable();
            $table->date('date_fond_finish')->nullable();
            $table->bigInteger('review_id')->unsigned()->nullable();
            $table->foreign('review_id')->references('id')->on('reviews');
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
        Schema::dropIfExists('helps');
    }
}
