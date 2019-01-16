<?php

use Illuminate\Database\Seeder;
use App\Carrec;

class slb_carrecs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrec::create(array(
            'id_carrec'         => 1,
            'nom_carrec'        => 'Actor',
            'descripcio_carrec' => 'Actor'
        ));
        Carrec::create(array(
            'id_carrec'         => 2,
            'nom_carrec'        => 'Director',
            'descripcio_carrec' => 'Director'
        ));
        Carrec::create(array(
            'id_carrec'         => 3,
            'nom_carrec'        => 'Tècnic de sala',
            'descripcio_carrec' => 'Tècnic de sala'
        ));
        Carrec::create(array(
            'id_carrec'         => 4,
            'nom_carrec'        => 'Traductor',
            'descripcio_carrec' => 'Traductor'
        ));
        Carrec::create(array(
            'id_carrec'         => 5,
            'nom_carrec'        => 'Ajustador',
            'descripcio_carrec' => 'Ajustador'
        ));
        Carrec::create(array(
            'id_carrec'         => 6,
            'nom_carrec'        => 'Lingüista',
            'descripcio_carrec' => 'Lingüista'
        ));
    }
}
