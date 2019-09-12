<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbRegistreProduccioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->dropColumn('final_sala');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->timestamp('final_sala')->after('inici_sala')->nullable();
        });
    }
}
