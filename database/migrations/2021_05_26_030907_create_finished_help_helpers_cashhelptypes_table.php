<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinishedHelpHelpersCashhelptypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_help_helpers_cashhelptypes', function (Blueprint $table) {
            $table->bigInteger('finished_help_helper_id')->unsigned();
            $table->foreign('finished_help_helper_id', 'finish_help_helper_id_foreign')->references('id')->on('finished_help_helpers')->onDelete('cascade');
            $table->bigInteger('cash_help_id')->unsigned();
            $table->foreign('cash_help_id')->references('id')->on('cash_help_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_help_helpers_cashhelptypes');
    }
}
