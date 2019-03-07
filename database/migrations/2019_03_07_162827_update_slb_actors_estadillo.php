<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbActorsEstadillo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_actors_estadillo', function (Blueprint $table) {
            $table->double('take_estadillo')->nullable()->change();
            $table->double('cg_estadillo')->nullable()->change();
            $table->double('canso_estaillo')->nullable()->change();
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
            $table->double('take_estadillo')->change();
            $table->double('cg_estadillo')->change();
            $table->double('canso_estaillo')->change();
        });
    }
}
