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
            'nom_departament' => 'Direcció',
            'descripcio_departament' => 'Usuaris del departament de direcció.'
        ));
        Departament::create(array(
            'id_departament' => '2',
            'nom_departament' => 'Producció',
            'descripcio_departament' => 'Usuaris del departament de producció.'
        ));
        Departament::create(array(
            'id_departament' => '3',
            'nom_departament' => 'Tècnic',
            'descripcio_departament' => 'Usuaris del departament tècnic.'
        ));
        Departament::create(array(
            'id_departament' => '4',
            'nom_departament' => 'Administració',
            'descripcio_departament' => 'Usuaris del departament d\'administració.'
        ));
        Departament::create(array(
            'id_departament' => '5',
            'nom_departament' => 'Sistemes',
            'descripcio_departament' => 'Usuaris del departament de Sistems & IT.'
        ));
    }
}
