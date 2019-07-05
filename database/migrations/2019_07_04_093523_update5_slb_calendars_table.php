<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update5SlbCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
        Schema::table('slb_calendars', function (Blueprint $table) {
            $table->integer('id_actor')->after('id_calendar');
            $table->integer('id_registre_entrada')->after('id_actor');
            $table->integer('setmana')->after('id_registre_entrada');
            $table->dropColumn('id_actor_estadillo');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_calendars', function (Blueprint $table) {
            $table->integer('id_actor_estadillo');
            $table->dropColumn('id_actor');
            $table->dropColumn('id_registre_entrada');
            $table->dropColumn('setmana');
        });
    }
}
