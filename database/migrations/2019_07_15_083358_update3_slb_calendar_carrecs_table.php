<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbCalendarCarrecsTable extends Migration
{
    public function up()
    {
        Schema::table('slb_calendar_carrecs', function (Blueprint $table) {
            $table->boolean('festiu')->default(0)->after('torn');
            $table->string('descripcio_festiu')->nullable()->after('festiu'); 
        });
    }

    public function down()
    {
        Schema::table('slb_calendar_carrecs', function (Blueprint $table) {
            $table->dropColumn('descripcio_festiu');
            $table->dropColumn('festiu');
        });
    }
}
