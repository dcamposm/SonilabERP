<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipusMedia extends Model
{
    protected $table = 'slb_tipus_media';
    protected $primaryKey = 'id_media';

    protected $fillable = [
        'nom_media',
        'descripcio_media'
    ];

    public function registreEntrades()
    {
        return $this->hasMany('App\RegistreEntrada', 'id_media', 'id_media');
    }
}
