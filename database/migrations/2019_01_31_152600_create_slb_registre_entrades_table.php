<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbRegistreEntradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_registre_entrades', function (Blueprint $table) {
            $table->increments('id_registre_entrada');
            $table->string('ot', 20)->default('');
            $table->string('oc', 20)->default('');
            $table->string('titol', 100);
            $table->timestamp('entrada')->useCurrent();
            $table->timestamp('sortida')->useCurrent();
            $table->integer('id_client')->default(0);
            $table->integer('id_servei')->default(0);
            $table->integer('id_idioma')->default(0);
            $table->integer('id_media')->default(0);
            $table->integer('minuts')->default(0);
            $table->integer('total_episodis')->default(0);
            $table->integer('episodis_setmanals')->default(0);
            $table->integer('entregues_setmanals')->default(0);
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
        Schema::dropIfExists('slb_registre_entrades');
    }
}
