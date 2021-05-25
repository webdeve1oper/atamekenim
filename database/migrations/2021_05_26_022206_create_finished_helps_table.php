<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishedHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_helps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('help_id');
            $table->foreign('help_id')->references('id')->on('helps')->onDelete('cascade');
            $table->date('help_date')->nullable();
            $table->string('amount')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('finished_helps');
    }
}
