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
            $table->string('sub_title')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->integer('help_location_country')->references('country_id')->on('countries')->nullable();
            $table->integer('help_location_region')->references('region_id')->on('regions')->nullable();
            $table->integer('help_location_city')->references('city_id')->on('cities')->nullable();
            $table->integer('fond_id')->references('id')->on('fonds')->nullable();
            $table->string('children_count')->default(0);
            $table->string('email');
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->json('social')->nullable();
            $table->text('video')->nullable();
            $table->boolean('status')->default(true);
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
