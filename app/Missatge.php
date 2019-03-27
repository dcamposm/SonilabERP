<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Missatge extends Model
{
    protected $table = 'slb_missatges';
    protected $primaryKey = 'id_missatge';

    protected $fillable = [
        'id_usuari',
        'missatge',
        'referencia',
        'id_referencia',
        'data_final',
    ];

    public function usuari()
    {
        return $this->belongsTo('App\User', 'id_usuari', 'id_usuari');
    }
}
