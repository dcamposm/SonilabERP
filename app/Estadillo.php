<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadillo extends Model
{
    protected $table = 'slb_estadillo';
    protected $primaryKey = 'id_estadillo';

    public  $fillable = [ 
        "id_registre_produccio", 
        "validat"
    ];

    public function actors()
    {
        return $this->hasMany('App\ActorEstadillo', 'id_estadillo', 'id_estadillo');
    }
    
    public function registrProduccio()
    {
        return $this->hasMany('App\Projecte', 'id_registre_produccio', 'id');
    }
}
