<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbRegistreEntradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registre_entrades', function (Blueprint $table) {
            $table->string('color_referencia')->default('#ffffff ')->after('estat');
            $table->string('titol_curt')->nullable()->after('titol');
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
            $table->dropColumn('color_referencia');
            $table->dropColumn('titol_curt');
        });
    }
}
