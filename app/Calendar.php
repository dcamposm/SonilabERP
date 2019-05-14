<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $table = 'slb_calendars';
    protected $primaryKey = 'id_calendar';
    protected $fillable = [
        //"id_calendar",
        "id_actor_estadillo",
        "num_takes",
        "data_inici",
        "data_fi",
        "num_sala",
    ];
    protected $casts = [
        'data_inici'  => 'date:d-m-Y H:i',
        'data_fi'  => 'date:d-m-Y H:i'
    ];

    public function actorEstadillo() {
        return $this->hasOne('App\ActorEstadillo','id','id_actor_estadillo');
    }
    

}
