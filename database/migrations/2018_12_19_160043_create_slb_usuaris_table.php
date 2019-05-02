<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlbUsuarisTable extends Migration
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
            $table->string('cognoms_usuari', 100);
            $table->string('email_usuari', 100)->unique();
            $table->string('alias_usuari')->unique();
            $table->string('contrasenya_usuari');
            $table->string('imatge_usuari');
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
