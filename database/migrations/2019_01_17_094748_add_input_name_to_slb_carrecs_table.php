<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInputNameToSlbCarrecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slb_carrecs', function (Blueprint $table) {
            $table->string('input_name', 25)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slb_carrecs', function (Blueprint $table) {
            $table->dropColumn('input_name');
        });
    }
}
