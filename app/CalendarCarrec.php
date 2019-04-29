<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCarrec extends Model
{
    protected $table = 'slb_calendar_carrecs';
    protected $primaryKey = 'id_calendar_carrec';
    
    
    protected $fillable = [
        "id_calendar_carrec",
        "id_carrec",
        "id_empleat",
        "num_sala",
        "data",
        "torn"
    ];
    
    
    
}
