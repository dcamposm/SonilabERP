<?php

use Illuminate\Database\Seeder;
use App\Estadillo;

class slb_estadillosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_estadillo')->delete();

        // Añadimos una entrada a esta tabla
        Estadillo::create(array(
            'id_estadillo' => '1',
            'id_registre_produccio' => '1'
        ));
    }
}
