<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_calendars', function (Blueprint $table) {
            $table->integer('id_actor_estadillo')->after('id_empleat');
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
            $table->dropColumn('id_actor_estadillo');
        });
    }
}
