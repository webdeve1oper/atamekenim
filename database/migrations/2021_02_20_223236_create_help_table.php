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
//            $table->string('destination');
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->integer('city_id')->references('city_id')->on('cities')->nullable();
            $table->integer('region_id')->references('region_id')->on('regions')->nullable();
            $table->text('body');
            $table->enum('status', ['wait','process','finished'])->default('wait');
            $table->date('date_fond_start')->nullable();
            $table->integer('review_id')->references('id')->on('reviews')->nullable();
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
