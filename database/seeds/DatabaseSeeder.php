<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Departament;
use App\EmpleatExtern;
use App\Idioma;
use App\IdiomaEmpleat;

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

        IdiomaEmpleat::unguard();
        $this->call(slb_idiomes_empleatsTableSeeder::class);
        IdiomaEmpleat::reguard();
    }
}
