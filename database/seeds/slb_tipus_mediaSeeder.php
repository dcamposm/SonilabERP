<?php

use Illuminate\Database\Seeder;
use App\TipusMedia;

class slb_tipus_mediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:: table('slb_tipus_media')->delete();
        TipusMedia:: create(array(
            'id_media'         => 1,
            'nom_media'        => 'Documental',
            'descripcio_media' => 'Documental.'
        ));
        TipusMedia:: create(array(
            'id_media'         => 2,
            'nom_media'        => 'Pel·lícula Animació',
            'descripcio_media' => 'Pel·lícula animada.'
        ));
        TipusMedia:: create(array(
            'id_media'         => 3,
            'nom_media'        => 'Pel·lícula Ficció A',
            'descripcio_media' => 'Pel·lícula de ficció A.'
        ));
        TipusMedia:: create(array(
            'id_media'         => 4,
            'nom_media'        => 'Pel·lícula Ficció B',
            'descripcio_media' => 'Pel·lícula de ficció B.'
        ));
        TipusMedia:: create(array(
            'id_media'         => 5,
            'nom_media'        => 'Serie Ficció',
            'descripcio_media' => 'Serie de ficció.'
        ));
        TipusMedia:: create(array(
            'id_media'         => 6,
            'nom_media'        => 'Serie Animació',
            'descripcio_media' => 'Serie d\'Animació.'
        ));
    }
}
