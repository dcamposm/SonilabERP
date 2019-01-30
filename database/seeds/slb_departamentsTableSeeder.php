<?php

use Illuminate\Database\Seeder;
use App\Departament;

class slb_departamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slb_departaments')->delete();

        // Añadimos una entrada a esta tabla
        Departament::create(array(
            'id_departament' => '1',
            'nom_departament' => 'Dir.Estudi',
            'descripcio_departament' => 'Usuari que interactua amb l\'aplicació per administrar-la.'
        ));
        Departament::create(array(
            'id_departament' => '2',
            'nom_departament' => 'Producció',
            'descripcio_departament' => 'Usuari que interactua amb l\'aplicació per administrar-la.'
        ));
        Departament::create(array(
            'id_departament' => '3',
            'nom_departament' => 'Tècnic',
            'descripcio_departament' => 'Usuari que interactua amb l\'aplicació per administrar-la.'
        ));
        Departament::create(array(
            'id_departament' => '4',
            'nom_departament' => 'Administració',
            'descripcio_departament' => 'Usuari que interactua amb l\'aplicació per administrar-la.'
        ));
    }
}
