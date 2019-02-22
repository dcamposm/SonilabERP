<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbEstadillo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_estadillo', function (Blueprint $table) {
            $table->increments('id_estadillo');
            $table->integer('tipus_media');
            $table->boolean('validat')->default(false);
            $table->integer('id_registre_entrada');
            $table->integer('id_registre_produccio');
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
        Schema::dropIfExists('slb_estadillo');
    }
}
