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
        RegistreEntrada:: create(array(
            'id_registre_entrada'         => 2,
            'ot'        => '',
            'oc'        => '',
            'titol'        => 'Dumboncio',
            'id_client'        => 2,
            'id_servei'        => 1,
            'id_idioma'        => 2,
            'id_media'        => 1,
            'minuts'        => 320,
            'total_episodis'        => 10,
            'episodis_setmanals'        => 1,
            'entregues_setmanals'        => 1,
            'estat' => 'Pendent'
        ));
        RegistreEntrada:: create(array(
            'id_registre_entrada'         => 3,
            'ot'        => '',
            'oc'        => '',
            'titol'        => 'Esteban y su camino a la gloria',
            'id_client'        => 3,
            'id_servei'        => 1,
            'id_idioma'        => 1,
            'id_media'        => 1,
            'minuts'        => 320,
            'total_episodis'        => 1,
            'episodis_setmanals'        => 1,
            'entregues_setmanals'        => 1,
            'estat' => 'Pendent'
        ));
    }
}
