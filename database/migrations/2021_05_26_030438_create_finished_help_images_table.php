<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishedHelpImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_help_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo');
            $table->unsignedBigInteger('finished_help_id');
            $table->foreign('finished_help_id')->references('id')->on('finished_helps')->onDelete('cascade');
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
        Schema::dropIfExists('finished_help_images');
    }
}
