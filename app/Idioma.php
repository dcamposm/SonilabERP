<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'slb_idiomes';
    protected $primaryKey = 'id_idioma';

    protected $fillable = [
        "idioma"
    ];
}
