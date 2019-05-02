<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update5SlbActorsEstadilloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_actors_estadillo', function (Blueprint $table) {
            $table->dropColumn('canso_estaillo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_actors_estadillo', function (Blueprint $table) {
            $table->double('canso_estaillo');
        });
    }
}
