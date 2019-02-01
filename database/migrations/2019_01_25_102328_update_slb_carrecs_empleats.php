<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbCarrecsEmpleats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Opcio 1
        Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->renameColumn('preu_carrec', 'preu_carrec1');//Actor->narrador,Director->Rotllo,Tecni->Sala
            $table->double('preu_docu')->default(0)->after('preu_carrec');
            $table->double('preu_video_tk')->default(0)->after('preu_carrec');
            $table->double('preu_video_cg')->default(0)->after('preu_carrec');
            $table->double('preu_cine_tk')->default(0)->after('preu_carrec');
            $table->double('preu_cine_cg')->default(0)->after('preu_carrec');
            $table->double('preu_carrec2')->default(0)->after('preu_carrec');//Actor->canço,Director->Minut,Tecni->Mix
        });
        //Opcio 2
        /*Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->renameColumn('preu_carrec', 'preu_carrec1');
            $table->double('preu_carrec2')->default(0)->after('preu_carrec');
            $table->integer('id_servei')->default(0)->after('id_idioma');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Opcio 1
        /*Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->renameColumn('preu_carrec1', 'preu_carrec');
            $table->dropColumn('preu_carrec2');
            $table->dropColumn('preu_cine_cg');
            $table->dropColumn('preu_cine_tk');
            $table->dropColumn('preu_video_cg');
            $table->dropColumn('preu_video_tk');
            $table->dropColumn('preu_docu');
        });*/
        //Opcio 2
        /*Schema::table('slb_carrecs_empleats', function (Blueprint $table) {
            $table->renameColumn('preu_carrec1', 'preu_carrec');
            $table->dropColumn('preu_carrec2');
            $table->dropColumn('id_servei');
        });*/
    }
}
