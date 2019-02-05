<?php

use Illuminate\Database\Seeder;
use App\Tarifa;

class slb_tarifasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slb_tarifas')->delete();
        Tarifa::create(array(
            'id' => '1',
            'nombre' => 'Preu rotllo',
            'id_carrec' => '2',
        ));
        Tarifa::create(array(
            'id' => '2',
            'nombre' => 'Preu minut',
            'id_carrec' => '2',            
        ));
        Tarifa::create(array(
            'id' => '3',
            'nombre' => 'Tarifa sala',
            'id_carrec' => '3',
        ));
        Tarifa::create(array(
            'id' => '4',
            'nombre' => 'Tarifa mix',
            'id_carrec' => '3',
        ));
        Tarifa::create(array(
            'id' => '5',
            'nombre' => 'Tarifa video take',
            'id_carrec' => '1',
        ));
        Tarifa::create(array(
            'id' => '6',
            'nombre' => 'Tarifa video cg',
            'id_carrec' => '1',
        ));
        Tarifa::create(array(
            'id' => '7',
            'nombre' => 'Tarifa cine take',
            'id_carrec' => '1',
        ));
        Tarifa::create(array(
            'id' => '8',
            'nombre' => 'Tarifa cine cg',
            'id_carrec' => '1',
        ));
        Tarifa::create(array(
            'id' => '9',
            'nombre' => 'Tarifa canso',
            'id_carrec' => '1',
        ));
        Tarifa::create(array(
            'id' => '10',
            'nombre' => 'Tarifa traductor',
            'id_carrec' => '4',
        ));
        Tarifa::create(array(
            'id' => '11',
            'nombre' => 'Tarifa ajustador',
            'id_carrec' => '5',
        ));
        Tarifa::create(array(
            'id' => '12',
            'nombre' => 'Tarifa lingüista',
            'id_carrec' => '6',
        ));
    }
}
