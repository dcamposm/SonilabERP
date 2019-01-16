<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Departament;
use App\EmpleatExtern;
use App\Idioma;
use App\Carrec;
use App\CarrecEmpleat;

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

        Idioma::unguard();
        $this->call(slb_idiomesTableSeeder::class);
        Idioma::reguard();

        Carrec::unguard();
        $this->call(slb_carrecs::class);
        Carrec::reguard();

        CarrecEmpleat::unguard();
        $this->call(slb_carrecs_empleats::class);
        CarrecEmpleat::reguard();
    }
}
