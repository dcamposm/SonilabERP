<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRegistreEntrada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registre_entrades', function (Blueprint $table) {
            $table->integer('id_usuari')->after('titol')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_registre_entrades', function (Blueprint $table) {
            $table->dropColumn('id_usuari');
        });
    }
}
