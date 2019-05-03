<?php

use App\Calendar;
use Illuminate\Database\Seeder;

class slb_CalendarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slb_calendar')->delete();
        Calendar::create(array(
            'id_calendar' => 1,
            'id_empleat' => 1,
            'id_registre_entrada' => 1,
            'num_takes' => 50,
            'data_inici' => '2019-04-25 00:00:00',
            'data_fi' => '2019-04-25 00:10:00',
            'num_sala' => 1,
        ));
        Calendar::create(array(
            'id_calendar' => 2,
            'id_empleat' => 2,
            'id_registre_entrada' => 1,
            'num_takes' => 100,
            'data_inici' => '2019-04-26 00:00:00',
            'data_fi' => '2019-04-26 00:10:00',
            'num_sala' => 1,
        ));
    }
}
