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
            'nom_departament' => 'testing',
            'descripcio_departament' => 'para probar'
        ));
    }
}
