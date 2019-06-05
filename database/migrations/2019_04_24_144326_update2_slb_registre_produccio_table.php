<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2SlbRegistreProduccioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->dateTime('data_entrega')->nullable()->after('id_registre_entrada');
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
            $table->dropColumn('data_entrega');
        });
    }
}
