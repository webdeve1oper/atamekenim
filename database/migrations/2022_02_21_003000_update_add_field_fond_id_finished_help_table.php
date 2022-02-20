<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddFieldFondIdFinishedHelpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finished_helps', function (Blueprint $table) {
            $table->bigInteger('fond_id')->unsigned();
            $table->foreign('fond_id')->references('id')->on('fonds')->default(20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finished_helps', function (Blueprint $table) {
            $table->dropColumn('fond_id');
        });
    }
}
