<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbEmpleatsExternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            $table->dropColumn('preu_actor');
            $table->dropColumn('preu_traductor');
            $table->dropColumn('preu_linguista');
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
            $table->string('preu_actor')->change();
            $table->string('preu_traductor')->change();
            $table->string('preu_linguista')->change();
        });
    }
}
