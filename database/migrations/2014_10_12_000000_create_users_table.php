<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slb_usuaris', function (Blueprint $table) {
            $table->increments('id_usuari');
            $table->string('nom_usuari', 50);
            $table->string('cognoms_usuari', 100);
            $table->string('email_usuari', 100)->unique();
            $table->string('alias_usuari', 255)->unique();
            $table->string('contrasenya_usuari', 255);
            $table->string('imatge_usuari', 250);
            $table->integer('id_departament');
            $table->rememberToken();
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
        Schema::dropIfExists('slb_usuaris');
    }
}
