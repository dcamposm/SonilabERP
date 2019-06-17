<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update4SlbCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_calendars', function (Blueprint $table) {
            $table->boolean('canso_calendar')->default(0)->after('num_takes');
            $table->boolean('narracio_calendar')->default(0)->after('canso_calendar');
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
            $table->dropColumn('canso_calendar');
            $table->dropColumn('narracio_calendar');
        });
    }
}
