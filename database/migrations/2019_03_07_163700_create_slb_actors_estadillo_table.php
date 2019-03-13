<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbActorsEstadilloTable extends Migration
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
            $table->integer('id_produccio');
            $table->integer('id_empleat');
            $table->double('take_estadillo')->nullable();
            $table->double('cg_estadillo')->nullable();
            $table->double('canso_estadillo')->nullable();
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
