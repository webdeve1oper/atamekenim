<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_districts', function (Blueprint $table) {
            $table->bigInteger('district_id')->unsigned();
            $table->foreign('district_id')->references('district_id')->on('districts')->onDelete('cascade');
            $table->bigInteger('fond_id')->unsigned();
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
        Schema::dropIfExists('fond_districts');
    }
}
