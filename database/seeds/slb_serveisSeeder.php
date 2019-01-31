<?php

use Illuminate\Database\Seeder;
use App\Servei;

class slb_serveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('slb_serveis')->delete();
        Servei:: create(array(
            'id_servei'         => 1,
            'nom_servei'        => 'Doblatge TV',
            'descripcio_servei' => 'Doblatge per a series de televisió.'
        ));
        Servei:: create(array(
            'id_servei'         => 2,
            'nom_servei'        => 'Doblatge cinema',
            'descripcio_servei' => 'Doblatge per a pel·lícules.'
        ));
    }
}
