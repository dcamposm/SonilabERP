<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleatExtern extends Model
{
    protected $table = 'slb_empleats_externs';
    protected $primaryKey = 'id_empleat';

    protected $fillable = [
        "nom_empleat", 
        "cognom1_empleat",
        "cognom2_empleat", 
        "sexe_empleat", 
        "nacionalitat_empleat", 
        "email_empleat", 
        "dni_empleat", 
        "telefon_empleat", 
        "direccio_empleat", 
        "codi_postal_empleat", 
        "naixement_empleat", 
        "nss_empleat", 
        "iban_empleat"
    ];

    public function carrec()
    {
        return $this->hasMany('App\CarrecEmpleat', 'id_empleat', 'id_empleat');
    }
    
    public function estadillo()
    {
        return $this->hasMany('App\ActorEstadillo', 'id_actor', 'id_empleat');
    }
    
    public function costos()
    {
        return $this->hasMany('App\EmpleatCost', 'id_empleat', 'id_empleat');
    }
    
    public function produccioTraductor()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_traductor', 'id_empleat');
    }
    
    public function produccioAjustador()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_ajustador', 'id_empleat');
    }
    
    public function produccioLinguista()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_linguista', 'id_empleat');
    }
    
    public function produccioDirector()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_director', 'id_empleat');
    }
    
    public function produccioTecnic()
    {
        return $this->hasMany('App\RegistreProduccio', 'id_tecnic_mix', 'id_empleat');
    }
}
