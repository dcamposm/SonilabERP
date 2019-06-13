<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCarrec extends Model
{
    protected $table = 'slb_calendar_carrecs';
    protected $primaryKey = 'id_calendar_carrec';

    protected $fillable = [
        "id_empleat",
        "num_sala",
        "data",
        "torn",
        "color_empleat",
    ];

    protected $casts = [
        'data'  => 'date:d-m-Y',
    ];
    
    public function sessio()
    {
        return $this->hasMany('App\Calendar', 'id_calendar_carrec', 'id_calendar_carrec');
    }
    
    public function empleat() {
        return $this->hasMany('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }
}
