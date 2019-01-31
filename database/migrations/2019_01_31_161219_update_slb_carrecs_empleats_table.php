<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbCarrecsEmpleatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->integer('id_tarifa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->dropColumn('id_tarifa');
        });
    }
}
