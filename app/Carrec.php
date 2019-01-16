<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrec extends Model
{
    protected $table = 'slb_carrecs';
    protected $primaryKey = 'id_carrec';

    protected $fillable = [
        'nom_carrec',
        'descripcio_carrec'
    ];
}
