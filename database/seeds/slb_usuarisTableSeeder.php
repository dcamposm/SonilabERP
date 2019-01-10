<?php

use Illuminate\Database\Seeder;

use App\User;

class slb_usuarisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Borramos los datos de la tabla
        DB::table('slb_usuaris')->delete();

        // Añadimos una entrada a esta tabla
        User::create(array(
            'id_usuari' => '1',
            'nom_usuari' => 'test',
            'cognoms_usuari' => 'test',
            'email_usuari' => 'test@test.com',
            'alias_usuari' => 'test',
            'contrasenya_usuari' => 'test',
            'imatge_usuari' => 'defecte.png',
            'id_departament' => '1'
        ));
    }
}
