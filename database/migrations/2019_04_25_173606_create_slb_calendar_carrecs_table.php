<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbCalendarCarrecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up() //tabla relacional entre cargos y calendario para insertar director y tecnico sala con su turno (maána/tarde)
    {
        Schema::create('slb_calendar_carrecs', function (Blueprint $table) {
            $table->increments('id_calendar_carrec');
            $table->integer('id_carrec');
            $table->integer('id_empleat');
            $table->integer('num_sala');
            $table->timestamp('id');
            $table->integer('torn');
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
        Schema::dropIfExists('slb_calendar_carrecs');
    }
}
