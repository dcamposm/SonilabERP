<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbEmpleatsExternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            $table->boolean('pc_empleat')->after('iban_empleat');
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
            $table->dropColumn('pc');
        });
    }
}
