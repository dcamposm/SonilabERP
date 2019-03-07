<?php

use Illuminate\Database\Seeder;
use App\RegistreProduccio;

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
        DB::table('slb_registres_produccio')->delete();

        // Añadimos una entrada a esta tabla
        RegistreProduccio::create(array(
            'subreferencia' => '1',
            'id_registre_entrada' => '1'
        ));
    }
}
