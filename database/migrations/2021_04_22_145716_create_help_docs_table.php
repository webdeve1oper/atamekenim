<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('original_name');
            $table->string('path');
            $table->bigInteger('help_id')->unsigned();
            $table->foreign('help_id')->references('id')->on('helps');
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
        Schema::dropIfExists('help_docs');
    }
}
