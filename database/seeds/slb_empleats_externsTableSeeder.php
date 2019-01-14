<?php

use Illuminate\Database\Seeder;
use App\EmpleatExtern;

class slb_empleats_externsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slb_empleats_externs')->delete();

        // Añadimos una entrada a esta tabla
        EmpleatExtern::create(array(
            'id_empleat' => '1',
            'nom_empleat' => 'Empleat',
            'cognoms_empleat' => 'Treballador',
            'sexe_empleat' => 'Home',
            'nacionalitat_empleat' => 'Español',
            'imatge_empleat' => 'defecte.png',
            'email_empleat' => 'empleat.treballador@gmail.com',
            'dni_empleat' => '11111111A',
            'telefon_empleat' => '666666666',
            'direccio_empleat' => 'C/ home i dona que treballen',
            'codi_postal_empleat' => '00666',
            'naixement_empleat' => \Carbon\Carbon::create(2000, 1, 1),
            'nss_empleat' => '666 999',
            'iban_empleat' => 'ES666666666',
            'actor' => true,
            'director' => false,
            'tecnic_sala' => false,
            'traductor' => false,
            'ajustador' => false,
            'linguista' => false,
            'preu_director' => 0,
            'preu_tecnic_sala' => 0,
            'preu_ajustador' => 0
        ));
    }
}
