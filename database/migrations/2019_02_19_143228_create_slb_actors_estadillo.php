<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbActorsEstadillo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_actors_estadillo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_estaillo');
            $table->integer('id_actor');
            $table->double('take_estaillo');
            $table->double('cg_actor');
            $table->double('canso_estaillo');
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
        Schema::dropIfExists('slb_actors_estadillo');
    }
}
