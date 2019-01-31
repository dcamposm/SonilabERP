<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_clients', function (Blueprint $table) {
            $table->increments('id_client');
            $table->string('nom_client', 50);
            $table->string('email_client', 100);
            $table->string('telefon_client', 15);
            $table->string('direccio_client', 100)->default('');
            $table->string('codi_postal_client', 5)->default('');
            $table->string('ciutat_client', 50)->default('');
            $table->string('pais_client', 50)->default('');
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
        Schema::dropIfExists('slb_clients');
    }
}
