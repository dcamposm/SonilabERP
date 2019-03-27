<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbMissatges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_missatges', function (Blueprint $table) {
            $table->increments('id_missatge');
            $table->integer('id_usuari');
            $table->text('missatge');
            $table->string('referencia', 100);
            $table->integer('id_referencia');
            $table->date('data_final');
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
        Schema::dropIfExists('slb_missatges');
    }
}
