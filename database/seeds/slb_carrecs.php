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
        DB::table('slb_carrecs')->delete();
        Carrec::create(array(
            'id_carrec'         => 1,
            'nom_carrec'        => 'Actor',
            'descripcio_carrec' => 'Actor',
            'input_name'        => 'actor'
        ));
        Carrec::create(array(
            'id_carrec'         => 2,
            'nom_carrec'        => 'Director',
            'descripcio_carrec' => 'Director',
            'input_name'        => 'director'
        ));
        Carrec::create(array(
            'id_carrec'         => 3,
            'nom_carrec'        => 'Tècnic de sala',
            'descripcio_carrec' => 'Tècnic de sala',
            'input_name'        => 'tecnic_sala'
        ));
        Carrec::create(array(
            'id_carrec'         => 4,
            'nom_carrec'        => 'Traductor',
            'descripcio_carrec' => 'Traductor',
            'input_name'        => 'traductor'
        ));
        Carrec::create(array(
            'id_carrec'         => 5,
            'nom_carrec'        => 'Ajustador',
            'descripcio_carrec' => 'Ajustador',
            'input_name'        => 'ajustador'
        ));
        Carrec::create(array(
            'id_carrec'         => 6,
            'nom_carrec'        => 'Lingüista',
            'descripcio_carrec' => 'Lingüista',
            'input_name'        => 'linguista'
        ));
    }
}
