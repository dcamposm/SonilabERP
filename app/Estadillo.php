<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadillo extends Model
{
    protected $table = 'slb_estadillo';
    protected $primaryKey = 'id_estadillo';

    public  $fillable = [ 
        "id_registre_produccio",
    ];

    public function actors()
    {
        return $this->hasMany('App\ActorEstadillo', 'id_estadillo', 'id_estadillo');
    }
    
    public function registreProduccio()
    {
        return $this->hasOne('App\RegistreProduccio', 'id', 'id_registre_produccio');
    }
    
    public function registres()
    {
        return $this->belongTo('App\RegistreProduccio');
    }
}
