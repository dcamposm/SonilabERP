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
        RegistreProduccio::create(array(
            'id'    =>  '3',
            'subreferencia' => '46',
            'id_registre_entrada' => '3',
            'data_entrega'  =>  '2019-04-26 00:00:00',
            'setmana'   =>  '2',
            'titol' =>  'Esteban and her path to glory(o algo asi...)',
            'titol_traduit' =>  'Esteban y su camino a la gloria',
            'qc_vo' =>  '1',
            'qc_me' =>  '1',
            'ppp'   =>  '1',
            'id_traductor'  =>  '1',
            'data_traductor' => '2019-04-08 00:00:00',
            'id_ajustador'  =>  '0',
            'data_ajustador'    =>  '2019-04-02 00:00:00',
            'id_linguista'  =>  '0',
            'data_linguista'    =>  '2019-04-01 00:00:00',
            'id_director'   =>  '1',
            'casting'   =>  '1',
            'propostes' =>  '1',
            'inserts'   =>  'No cal fer',
            'estadillo' =>  '1',
            'vec'   =>  '1',
            'convos'    =>  '1',
            'inici_sala'    =>  '2019-04-24 00:00:00',
            'pps'   =>  '1',
            'final_sala' => '2019-04-25 00:00:00',
            'id_tecnic_mix' =>  '0',
            'data_tecnic_mix'   =>  '2019-04-09 00:00:00',
            'retakes' => 'Fet',
            'qc_mix'    =>  '1',
            'ppe'   =>  '1',
            'estat' =>  'Finalitzada'
        ));

        RegistreProduccio::create(array(
            'id'    =>  '2',
            'subreferencia' => '47',
            'id_registre_entrada' => '2',
            'data_entrega'  =>  '2019-04-26 00:00:00',
            'setmana'   =>  '2',
            'titol' =>  'Dumboncio',
            'titol_traduit' =>  'Dumbo',
            'qc_vo' =>  '1',
            'qc_me' =>  '1',
            'ppp'   =>  '1',
            'id_traductor'  =>  '1',
            'data_traductor' => '2019-03-08 00:00:00',
            'id_ajustador'  =>  '0',
            'data_ajustador'    =>  '2019-03-02 00:00:00',
            'id_linguista'  =>  '0',
            'data_linguista'    =>  '2019-03-01 00:00:00',
            'id_director'   =>  '1',
            'casting'   =>  '1',
            'propostes' =>  '1',
            'inserts'   =>  'No cal fer',
            'estadillo' =>  '1',
            'vec'   =>  '1',
            'convos'    =>  '1',
            'inici_sala'    =>  '2019-03-24 00:00:00',
            'pps'   =>  '1',
            'final_sala' => '2019-03-25 00:00:00',
            'id_tecnic_mix' =>  '0',
            'data_tecnic_mix'   =>  '2019-03-09 00:00:00',
            'retakes' => 'Fet',
            'qc_mix'    =>  '1',
            'ppe'   =>  '1',
            'estat' =>  'Pendent'
        ));
    }
}
