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
            'nombre' => 'Preu rotllo'
        ));
        Tarifa::create(array(
            'id' => '2',
            'nombre' => 'Preu minut'
        ));
        Tarifa::create(array(
            'id' => '3',
            'nombre' => 'Tarifa sala'
        ));
        Tarifa::create(array(
            'id' => '4',
            'nombre' => 'Tarifa mix'
        ));
        Tarifa::create(array(
            'id' => '5',
            'nombre' => 'Tarifa sala'
        ));
        Tarifa::create(array(
            'id' => '6',
            'nombre' => 'Tarifa video take'
        ));
        Tarifa::create(array(
            'id' => '7',
            'nombre' => 'Tarifa video cg'
        ));
        Tarifa::create(array(
            'id' => '8',
            'nombre' => 'Tarifa cine take'
        ));
        Tarifa::create(array(
            'id' => '9',
            'nombre' => 'Tarifa cine cg'
        ));
        Tarifa::create(array(
            'id' => '10',
            'nombre' => 'Tarifa canso'
        ));
        Tarifa::create(array(
            'id' => '11',
            'nombre' => 'Tarifa traductor'
        ));
        Tarifa::create(array(
            'id' => '12',
            'nombre' => 'Tarifa ajustador'
        ));
        Tarifa::create(array(
            'id' => '13',
            'nombre' => 'Tarifa lingüista'
        ));
    }
}
