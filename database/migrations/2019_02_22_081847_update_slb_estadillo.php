<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbEstadillo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_estadillo', function (Blueprint $table) {
            $table->dropColumn('tipus_media');
            $table->renameColumn('id_registre_entrada', 'referencia');
            $table->renameColumn('id_registre_produccio', 'subreferencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_estadillo', function (Blueprint $table) {
            $table->integer('tipus_media');
            $table->renameColumn('referencia', 'id_registre_entrada');
            $table->renameColumn('subreferencia', 'id_registre_produccio');
        });
    }
}
