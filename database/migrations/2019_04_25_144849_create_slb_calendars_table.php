<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_calendars', function (Blueprint $table) {
            $table->increments('id_calendar');
            $table->integer('id_empleat');
            $table->integer('id_registre_entrada');
            $table->integer('num_takes');
            $table->timestamp('data_inici');
            $table->timestamp('data_fi');
            $table->integer('num_sala');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slb_calendars');
    }
}
