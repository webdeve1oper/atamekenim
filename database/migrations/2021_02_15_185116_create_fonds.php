<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->string('logo')->nullable();
            $table->string('organization_form')->nullable();
            $table->string('website')->nullable();
            $table->date('foundation_date')->nullable();
            $table->string('bin')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('created_date')->nullable();
            $table->string('address')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('help_range')->nullable();
            $table->string('help_cash')->default(0);
            $table->text('about')->nullable();
            $table->text('mission')->nullable();
            $table->json('social')->nullable();
            $table->text('video')->nullable();
            $table->json('requisites')->nullable();
            $table->json('offices')->nullable();
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
        //
        Schema::dropIfExists('fonds');
    }
}
