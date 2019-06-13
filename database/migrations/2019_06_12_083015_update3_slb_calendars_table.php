<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_calendars', function (Blueprint $table) {
            $table->integer('id_director')->nullable()->default(null)->after('asistencia');
            $table->string('color_calendar')->nullable()->default(null)->after('id_director');
            $table->renameColumn('num_sala', 'id_calendar_carrecs');
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
            $table->dropColumn('id_director');
            $table->dropColumn('color_calendar');
            $table->renameColumn('id_calendar_carrecs', 'num_sala');
        });
    }
}
