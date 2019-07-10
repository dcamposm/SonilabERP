<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsSlbCalendarCarrecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_calendar_carrecs', function (Blueprint $table) { 
            $table->dropColumn('color_empleat');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('slb_calendar_carrecs', function (Blueprint $table) {
            $table->string('color_empleat')->nullable()->default(null)->after('torn');
        });
    }
}
