<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorEstadillo extends Model
{
    protected $table = 'slb_actors_estadillo';
    protected $primaryKey = ('id');

    protected $fillable = [
        "id_estadillo",
        "id_actor",
        "take_estaillo", 
        "cg_actor", 
        "canso_estaillo"
    ];

    public function empleat()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }

    public function estadillo()
    {
        return $this->belongsTo('App\Idioma', 'id_estadillo', 'id_estadillo');
    }
}
