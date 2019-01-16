<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarrecEmpleat extends Model
{
    protected $table = 'slb_carrecs_empleats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleat',
        'id_carrec',
        'id_idioma',
        'empleat_homologat',
        'preu_carrec'
    ];
}
