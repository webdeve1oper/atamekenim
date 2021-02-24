<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpFondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_fond', function (Blueprint $table) {
            $table->bigInteger('fond_id')->unsigned();
            $table->bigInteger('help_id')->unsigned();
            $table->enum('fond_status', ['disable', 'enable']);
            $table->foreign('help_id')->references('id')->on('helps')->onDelete('cascade');
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
        Schema::dropIfExists('help_fond');
    }
}
