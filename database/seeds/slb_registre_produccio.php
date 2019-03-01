<?php

use Illuminate\Database\Seeder;
use App\Projecte;

class slb_registre_produccio extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_registre_produccio')->delete();

        // Añadimos una entrada a esta tabla
        Projecte::create(array(
            'id' => '1',
            'id_registre_entrada' => '1',
            'id_sub' => '0',
            'nom' => 'Registre de prova',
            'setmana' => '1'
        ));
    }
}
