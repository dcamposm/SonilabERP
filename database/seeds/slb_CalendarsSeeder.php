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
        DB::table('slb_calendars')->delete();
        Calendar::create(array(
            'id_calendar' => 1,
            'id_actor_estadillo'=>1,
            'num_takes' => 33,
            'data_inici' => '2019-04-25 16:10:00',
            'data_fi' => '2019-04-25 17:55:00',
            'num_sala' => 1,
        ));
        Calendar::create(array(
            'id_calendar' => 2,
            'id_actor_estadillo'=>2,
            'num_takes' => 28,
            'data_inici' => '2019-04-26 19:45:00',
            'data_fi' => '2019-04-26 20:50:00',
            'num_sala' => 1,
            'asistencia' => 0
        ));
        Calendar::create(array(
            'id_calendar' => 3,
            'id_actor_estadillo'=>3,
            'num_takes' => 10,
            'data_inici' => '2019-04-26 10:00:00',
            'data_fi' => '2019-04-26 10:40:00',
            'num_sala' => 1,
        ));
        Calendar::create(array(
            'id_calendar' => 4,
            'id_actor_estadillo'=>4,
            'num_takes' => 46,
            'data_inici' => '2019-04-26 08:30:00',
            'data_fi' => '2019-04-26 12:30:00',
            'num_sala' => 3,
        ));
        Calendar::create(array(
            'id_calendar' => 5,
            'id_actor_estadillo'=>5,
            'num_takes' => 22,
            'data_inici' => '2019-04-26 19:30:00',
            'data_fi' => '2019-04-26 20:45:00',
            'num_sala' => 3,
        ));
        Calendar::create(array(
            'id_calendar' => 6,
            'id_actor_estadillo'=>5,
            'num_takes' => 5,
            'data_inici' => '2019-04-26 21:00:00',
            'data_fi' => '2019-04-26 21:30:00',
            'num_sala' => 3,
            'asistencia' => 1,
        ));
        Calendar::create(array(
            'id_calendar' => 7,
            'id_actor_estadillo'=>2,
            'num_takes' => 10,
            'data_inici' => '2019-04-30 21:00:00',
            'data_fi' => '2019-04-30 21:30:00',
            'num_sala' => 3
        ));
        Calendar::create(array(
            'id_calendar' => 8,
            'id_actor_estadillo'=>2,
            'num_takes' => 1,
            'data_inici' => '2019-04-30 20:58:00',
            'data_fi' => '2019-04-30 20:59:00',
            'num_sala' => 3
        ));
    }
}
