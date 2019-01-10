<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Departament;
use App\EmpleatExtern;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Departament::unguard();
        $this->call(slb_departamentsTableSeeder::class);
        Departament::reguard();

        User::unguard();
        $this->call(slb_usuarisTableSeeder::class);
        User::reguard();

        EmpleatExtern::unguard();
        $this->call(slb_empleats_externsTableSeeder::class);
        EmpleatExtern::reguard();
    }
}
