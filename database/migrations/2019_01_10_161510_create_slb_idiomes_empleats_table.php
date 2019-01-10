<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbIdiomesEmpleatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_idiomes_empleats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_empleat');
            $table->integer('id_idioma');
            $table->boolean('empleat_homologat')->default(false);
            $table->double('preu_actor')->default(0);
            $table->double('preu_traductor')->default(0);
            $table->double('preu_linguista')->default(0);
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
        Schema::dropIfExists('slb_idiomes_empleats');
    }
}
