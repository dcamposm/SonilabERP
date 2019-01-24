<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2SlbUsuarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_usuaris', function (Blueprint $table) {
            
            $table->renameColumn('cognoms_usuari', 'cognom1_usuari');
            $table->string('cognom2_usuari',50)->after('cognoms_usuari');
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
            $table->renameColumn('cognom1_usuari', 'cognoms_usuari');
            $table->dropColumn('cognom2_usuari');
        });
    }
}
