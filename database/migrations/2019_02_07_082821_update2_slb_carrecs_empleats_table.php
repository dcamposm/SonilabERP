<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2SlbCarrecsEmpleatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->boolean('rotllo')->default(false)->after('empleat_homologat');
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
            $table->dropColumn('rotllo');
        });
    }
}
