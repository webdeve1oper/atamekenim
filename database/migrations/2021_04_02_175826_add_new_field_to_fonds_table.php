<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToFondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fonds', function (Blueprint $table) {
            $table->string('work')->nullable();
            $table->string('fio')->nullable();
            $table->bigInteger('organ_id')->unsigned()->default(1);
            $table->foreign('organ_id')->references('id')->on('organ_legal_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonds', function (Blueprint $table) {
            //
            $table->dropForeign('fonds_organ_id_foreign');
            $table->dropColumn('organ_id');
            $table->dropColumn('work');
            $table->dropColumn('fio');
        });
    }
}
