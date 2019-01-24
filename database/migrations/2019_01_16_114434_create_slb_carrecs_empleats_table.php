<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbCarrecsEmpleatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_carrecs_empleats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empleat');
            $table->integer('id_carrec');
            $table->integer('id_idioma')->default(0);
            $table->boolean('empleat_homologat')->default(false);
            $table->double('preu_carrec')->default(0);
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
        Schema::dropIfExists('slb_carrecs_empleats');
    }
}
