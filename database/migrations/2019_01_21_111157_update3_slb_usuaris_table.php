<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbUsuarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_usuaris', function (Blueprint $table) {
            $table->longtext('imatge_usuari')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_usuaris', function (Blueprint $table) {
            $table->string('imatge_usuari')->default('defecte.png')->change();
        });
    }
}
