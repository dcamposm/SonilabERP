<?php

use Illuminate\Database\Seeder;
use App\IdiomaEmpleat;

class slb_idiomes_empleatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_idiomes_empleats')->delete();

        // Añadimos una entrada a esta tabla
        IdiomaEmpleat::create(array(
            'id' => '1',
            'id_empleat' => 1,
            'id_idioma' => 1,
            'empleat_homologat' => 1,
            'preu_actor' => 69,
            'preu_traductor' => 0,
            'preu_linguista' => 0
        ));
        IdiomaEmpleat::create(array(
            'id' => '2',
            'id_empleat' => 1,
            'id_idioma' => 2,
            'empleat_homologat' => 0,
            'preu_actor' => 666,
            'preu_traductor' => 0,
            'preu_linguista' => 0
        ));
    }
}
