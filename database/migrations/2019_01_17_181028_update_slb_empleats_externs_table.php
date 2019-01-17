<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSlbEmpleatsExternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            
            $table->renameColumn('cognoms_empleat', 'cognom1_empleat');
            $table->string('cognom2_empleat',50)->after('cognoms_empleat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_empleats_externs', function (Blueprint $table) {
            $table->string('congnoms')->change();
        });
    }
}
