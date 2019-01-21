<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2SlbEmpleatsExternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            $table->longtext('imatge_empleat')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            $table->string('imatge_empleat')->default('defecte.png')->change();
        });
    }
}
