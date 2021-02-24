<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->nullable();
            $table->bigInteger('iin');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('patron')->nullable();
            $table->date('born')->nullable();
            $table->integer('born_location_country')->references('country_id')->on('countries')->nullable();
            $table->integer('born_location_region')->references('region_id')->on('regions')->nullable();
            $table->integer('born_location_city')->references('city_id')->on('cities')->nullable();
            $table->integer('live_location_country')->references('country_id')->on('countries')->nullable();
            $table->integer('live_location_region')->references('region_id')->on('regions')->nullable();
            $table->integer('live_location_city')->references('city_id')->on('cities')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->enum('gender', ['none','male', 'female'])->default('none');
            $table->string('children_count')->default(0);
            $table->string('phone')->nullable();
            $table->text('about')->nullable();
            $table->string('password');
            $table->boolean('status')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
