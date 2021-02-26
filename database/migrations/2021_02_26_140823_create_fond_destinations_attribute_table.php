<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondDestinationsAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_destinations_attribute', function (Blueprint $table) {
            $table->bigInteger('destination_attribute_id')->unsigned();
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('destination_attribute_id')->references('id')->on('destinations_attribute')->onDelete('cascade');
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
        Schema::dropIfExists('fond_destinations_attribute');
    }
}
