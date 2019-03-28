<?php

use Illuminate\Database\Seeder;
use App\RegistreEntrada;

class slb_registre_entradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('slb_registre_entrades')->delete();
        RegistreEntrada:: create(array(
            'id_registre_entrada'         => 1,
            'ot'        => '',
            'oc'        => '',
            'titol'        => 'Registre de prova',
            'id_client'        => 1,
            'id_servei'        => 1,
            'id_idioma'        => 1,
            'id_media'        => 1,
            'minuts'        => 69,
            'total_episodis'        => 1,
            'episodis_setmanals'        => 1,
            'entregues_setmanals'        => 1,
            'estat' => 'Pendent'
        ));
    }
}
