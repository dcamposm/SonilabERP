<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update4SlbActorsEstadilloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_actors_estadillo', function (Blueprint $table) {
            $table->renameColumn('id_empleat', 'id_actor');

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
            $table->renameColumn('id_actor', 'id_empleat');
        });
    }
}
