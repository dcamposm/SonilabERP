<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropcolumnRegistresProduccioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->dropColumn('subtitol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->string('subtitol')->default('');
        });
    }
}
