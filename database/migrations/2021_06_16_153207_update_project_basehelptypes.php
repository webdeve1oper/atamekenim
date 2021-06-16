<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectBasehelptypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_basehelptypes', function (Blueprint $table) {
            $table->dropForeign('project_basehelptypes_project_id_foreign');
            $table->dropForeign('project_basehelptypes_base_help_id_foreign');
            $table->foreign('base_help_id')->references('id')->on('add_help_types')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('fonds')->onDelete('cascade');
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
    }
}
