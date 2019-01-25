<?php

use Illuminate\Database\Seeder;
use App\Idioma;

class slb_idiomesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_idiomes')->delete();

        // Añadimos una entrada a esta tabla
        Idioma::create(array(
            'id_idioma' => '1',
            'idioma' => 'Català'
        ));
        Idioma::create(array(
            'id_idioma' => '2',
            'idioma' => 'Castellà'
        ));
        Idioma::create(array(
            'id_idioma' => '3',
            'idioma' => 'Anglès'
        ));
    }
}
