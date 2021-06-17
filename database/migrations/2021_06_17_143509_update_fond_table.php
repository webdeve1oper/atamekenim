<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('fonds', 'requisites')){
            Schema::table('fonds', function (Blueprint $table) {
                $table->dropColumn('requisites');
                $table->dropColumn('offices');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fonds', function (Blueprint $table) {
            $table->json('requisites')->nullable();
            $table->json('offices')->nullable();
        });
    }
}
