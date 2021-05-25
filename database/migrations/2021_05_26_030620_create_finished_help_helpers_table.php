<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishedHelpHelpersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_help_helpers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('finish_help_id');
            $table->foreign('finish_help_id')->references('id')->on('finished_helps')->onDelete('cascade');
            $table->enum('type', ['fiz', 'yur'])->default('fiz');
            $table->boolean('anonim')->default(false);
            $table->string('fio')->nullable();
            $table->string('iin')->nullable();
            $table->string('bin')->nullable();
            $table->string('title')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('finished_help_helpers');
    }
}
