<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fond_offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('fond_id')->references('id')->on('fonds')->onDelete('cascade');
            $table->string('leader')->nullable();
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('time')->nullable();
            $table->boolean('central')->default(0);
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
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
        Schema::dropIfExists('fond_offices');
    }
}
