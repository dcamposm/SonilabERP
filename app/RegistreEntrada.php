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
        'titol_curt',
        'sortida',
        'id_usuari',
        'id_client',
        'id_servei',
        'id_idioma',
        'id_media',
        'minuts',
        'total_episodis',
        'episodis_setmanals',
        'entregues_setmanals',
        'estat',
        'color_referencia'
    ];
    
    protected $appends = ['referencia_titol'];
    
    public function getReferenciaTitolAttribute() {
        return $this->id_registre_entrada.' '.$this->titol;
    }    
    
    public function getReferenciaTitolPack($setmana) {
        $registre = array_filter($this->registreProduccio->toArray(), function ($registreProuduccio) use ($setmana){
            return($registreProuduccio['setmana'] == $setmana);
        });
        
        $first = reset($registre);
        $last = end($registre);
        
        if ($first['subreferencia'] == 0){
            return $this->id_registre_entrada.' '.($this->titol_curt ? $this->titol_curt : $this->titol);
        } else {
            return $this->id_registre_entrada.' '.($this->titol_curt ? $this->titol_curt : $this->titol).' '.$first['subreferencia'].'_'.$last['subreferencia'];
        }
    } 
    
    public function usuari()
    {
        return $this->belongsTo('App\User', 'id_usuari', 'id_usuari');
    }
    
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

    public function registreProduccio()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_registre_entrada', 'id_registre_entrada');
    }
    
    public function calendar()
    {
        return $this->hasMany('App\Calendar', 'id_registre_entrada', 'id_registre_entrada');
    }
}
