<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistreEntrada extends Model
{
    protected $table = 'slb_registre_entrades';
    protected $primaryKey = 'id_registre_entrada';

    protected $fillable = [
        'id_registre_entrada',
        'ot',
        'oc',
        'titol',
        'entrada',
        'sortida',
        'id_client',
        'id_servei',
        'id_idioma',
        'id_media',
        'minuts',
        'total_episodis',
        'episodis_setmanals',
        'entregues_setmanals',
        'estat'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'id_client', 'id_client');
    }

    public function servei()
    {
        return $this->belongsTo('App\Servei', 'id_servei', 'id_servei');
    }

    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'id_idioma', 'id_idioma');
    }

    public function media()
    {
        return $this->belongsTo('App\TipusMedia', 'id_media', 'id_media');
    }
}
