<?php

use Illuminate\Database\Seeder;
use App\ActorEstadillo;

class slb_actors_estadillosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_actors_estadillo')->delete();

        // Añadimos una entrada a esta tabla
        ActorEstadillo::create(array(
            'id' => '1',
            'id_produccio' => '1',
            'id_empleat' => '1',
            'take_estadillo' => '20',
            'cg_estadillo' => '4',
            'canso_estadillo' => '0'
        ));
    }
}
