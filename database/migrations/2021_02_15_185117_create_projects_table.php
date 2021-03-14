<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('website')->nullable();
            $table->string('duration')->nullable();
            $table->string('logo')->nullable();
            $table->bigInteger('fond_id')->unsigned();
            $table->date('date_created')->nullable();
            $table->integer('help_location_country')->references('country_id')->on('countries')->nullable();
            $table->integer('help_location_region')->references('region_id')->on('regions')->nullable();
            $table->integer('help_location_city')->references('city_id')->on('cities')->nullable();
            $table->foreign('fond_id')->references('id')->on('fonds')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->json('social')->nullable();
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
        //
        Schema::dropIfExists('projects');
    }
}
