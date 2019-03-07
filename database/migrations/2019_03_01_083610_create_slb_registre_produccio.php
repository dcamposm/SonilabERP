<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbRegistreProduccio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_registre_produccio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_registre_entrada');
            $table->integer('id_sub');
            $table->integer('setmana');
            $table->string('nom');
            $table->boolean('estadillo')->default(false);
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
        Schema::dropIfExists('slb_registre_produccio');
    }
}
