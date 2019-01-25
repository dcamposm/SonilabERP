<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleatExternTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_empleats_externs', function (Blueprint $table) {
            $table->increments('id_empleat');
            $table->string('nom_empleat', 100);
            $table->string('cognoms_empleat', 100);
            $table->string('sexe_empleat', 15);
            $table->string('nacionalitat_empleat', 50);
            $table->string('imatge_empleat')->default('defecte.png');
            $table->string('email_empleat', 150)->unique();
            $table->string('dni_empleat', 9)->unique();
            $table->string('telefon_empleat', 12);
            $table->string('direccio_empleat');
            $table->string('codi_postal_empleat', 5);
            $table->timestamp('naixement_empleat');
            $table->string('nss_empleat')->unique();
            $table->string('iban_empleat');
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
        Schema::dropIfExists('slb_empleats_externs');
    }
}
