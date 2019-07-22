<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorEstadillo extends Model
{
    protected $table = 'slb_actors_estadillo';
    protected $primaryKey = 'id';

    protected $fillable = [
        "id_produccio",
        "id_actor",
        "take_estadillo", 
        "cg_estadillo", 
        "canso_estadillo",
        "narracio_estadillo"
    ];
    
    protected $appends = ['nom_cognom'];
    
    public function getNomCognomAttribute() {
        return $this->empleat->nom_empleat.' '.$this->empleat->cognom1_empleat.' '.$this->empleat->cognom2_empleat;
    }
    
    public function empleat()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_actor', 'id_empleat');
    }

    public function estadillo()
    {
        return $this->belongsTo('App\Estadillo', 'id_produccio', 'id_estadillo');
    }
}
