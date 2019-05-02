<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumn2SlbRegistreProduccioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_registres_produccio', function (Blueprint $table) {
            $table->dropColumn('data_entrega');
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
            $table->timestamp('data_entrega');
        });
    }
}
