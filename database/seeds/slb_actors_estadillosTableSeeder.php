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
            'id_actor' => '1',
            'take_estadillo' => '20',
            'cg_estadillo' => '4',
            'canso_estaillo' => '0'
        ));

        ActorEstadillo::create(array(
            'id' => '2',
            'id_produccio' => '2',
            'id_actor' => '1',
            'take_estadillo' => '20',
            'cg_estadillo' => '4',
            'canso_estaillo' => '0'
        ));
        ActorEstadillo::create(array(
            'id' => '3',
            'id_produccio' => '2',
            'id_actor' => '2',
            'take_estadillo' => '200',
            'cg_estadillo' => '4',
            'canso_estaillo' => '0'
        ));
        ActorEstadillo::create(array(
            'id' => '4',
            'id_produccio' => '3',
            'id_actor' => '2',
            'take_estadillo' => '2',
            'cg_estadillo' => '4',
            'canso_estaillo' => '0'
        ));
        ActorEstadillo::create(array(
            'id' => '5',
            'id_produccio' => '3',
            'id_actor' => '3',
            'take_estadillo' => '2',
            'cg_estadillo' => '4',
            'canso_estaillo' => '0'
        ));
    }
}
