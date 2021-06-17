<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondRequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_requisites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('fond_id')->references('id')->on('fonds')->onDelete('cascade');
            $table->string('bin');
            $table->string('iik')->nullable();
            $table->string('bik')->nullable();
            $table->string('name')->nullable();
            $table->string('leader')->nullable();
            $table->string('yur_address')->nullable();
            $table->boolean('aggree')->nullable();
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
        Schema::dropIfExists('fond_requisites');
    }
}
