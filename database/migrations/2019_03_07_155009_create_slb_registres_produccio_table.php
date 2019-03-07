<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbRegistresProduccioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_registres_produccio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subreferencia')->default(0);
            $table->integer('id_registre_entrada')->default(0);
            $table->timestamp('data_entrega');
            $table->integer('setmana')->default(0);
            $table->string('titol')->default('');
            $table->string('titol_traduit')->default('');
            $table->boolean('qc_vo')->default(false);
            $table->boolean('qc_me')->default(false);
            $table->boolean('ppp')->default(false);
            $table->integer('id_traductor')->default(0);
            $table->timestamp('data_traductor');
            $table->integer('id_ajustador')->default(0);
            $table->timestamp('data_ajustador');
            $table->integer('id_linguista')->default(0);
            $table->timestamp('data_linguista');
            $table->integer('id_director')->default(0);
            $table->boolean('casting')->default(false);
            $table->boolean('propostes')->default(false);
            $table->string('subtitol')->default('');
            $table->enum('inserts', ['Cal fer', 'No cal fer', 'Fet'])->default('No cal fer');
            $table->boolean('estadillo')->default(false);
            $table->boolean('vec')->default(false);
            $table->boolean('convos')->default(false);
            $table->timestamp('inici_sala');
            $table->integer('id_tecnic_mix')->default(0);
            $table->timestamp('data_tecnic_mix');
            $table->enum('retakes', ['Si', 'No', 'Fet'])->default('No');
            $table->boolean('qc_mix')->default(false);
            $table->boolean('ppe')->default(false);
            $table->enum('estat', ['Pendent', 'Cancel·lada', 'Finalitzada'])->default('Pendent');
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
        Schema::dropIfExists('slb_registres_produccio');
    }
}
