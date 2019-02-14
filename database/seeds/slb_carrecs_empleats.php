<?php

use Illuminate\Database\Seeder;
use App\CarrecEmpleat;

class slb_carrecs_empleats extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slb_carrecs_empleats')->delete();
        CarrecEmpleat::create(array(
            'id'                => 1,
            'id_empleat'        => 1,
            'id_carrec'         => 1,
            'id_idioma'         => 1,
            'empleat_homologat' => false,
            'preu_carrec'       => 69,
            'id_tarifa'         => 6
        ));
        CarrecEmpleat::create(array(
            'id'                => 2,
            'id_empleat'        => 1,
            'id_carrec'         => 1,
            'id_idioma'         => 2,
            'empleat_homologat' => false,
            'preu_carrec'       => 45,
            'id_tarifa'         => 7
        ));
        CarrecEmpleat::create(array(
            'id'                => 3,
            'id_empleat'        => 1,
            'id_carrec'         => 4,
            'id_idioma'         => 1,
            'empleat_homologat' => true,
            'preu_carrec'       => 99,
            'id_tarifa'         => 12
        ));
        CarrecEmpleat::create(array(
            'id'                => 4,
            'id_empleat'        => 1,
            'id_carrec'         => 2,
            'id_idioma'         => 0,
            'empleat_homologat' => false,
            'preu_carrec'       => 666,
            'id_tarifa'         => 1
        ));
    }
}
