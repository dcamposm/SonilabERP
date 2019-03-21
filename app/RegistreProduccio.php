<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistreProduccio extends Model
{
    protected $table = 'slb_registres_produccio';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subreferencia',
        'id_registre_entrada',
        'data_entrega',
        'setmana',
        'titol',
        'titol_traduit',
        'qc_vo',
        'qc_me',
        'ppp',
        'id_traductor',
        'data_traductor',
        'id_ajustador',
        'data_ajustador',
        'id_linguista',
        'data_linguista',
        'id_director',
        'casting',
        'propostes',
        'subtitol',
        'inserts',
        'estadillo',
        'vec',
        'convos',
        'inici_sala',
        'id_tecnic_mix',
        'data_tecnic_mix',
        'retakes',
        'qc_mix',
        'ppe',
        'estat'
    ];
    
    public function getEstadillo()
    {
            return $this->hasOne('App\Estadillo', 'id_registre_produccio');
    }
    
    public function estadillo()
    {
        return $this->belongTo('App\Estadillo');
    }
}
