<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdiomaEmpleat extends Model
{
    protected $table = 'slb_idiomes_empleats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleat',
        'id_idioma',
        'empleat_homologat',
        'preu_actor',
        'preu_traductor',
        'preu_linguista'
    ];
}
