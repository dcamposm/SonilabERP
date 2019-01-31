<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'slb_tarifas';

    protected $fillable = [
        "nombre"
    ];
}
