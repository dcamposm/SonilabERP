<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update3SlbActorsEstadilloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_actors_estadillo', function (Blueprint $table) {
            $table->double('take_estadillo')->nullable();
            $table->double('cg_estadillo')->nullable();
            $table->double('canso_estaillo')->nullable();
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
            $table->dropColumn('take_estadillo');
            $table->dropColumn('cg_estadillo');
            $table->dropColumn('canso_estaillo');
        });
    }
}
