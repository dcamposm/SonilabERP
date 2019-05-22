<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCarrec extends Model
{
    protected $table = 'slb_calendar_carrecs';
    protected $primaryKey = 'id_calendar_carrec';

    protected $fillable = [
        "id_carrec",
        "id_empleat",
        "num_sala",
        "data",
        "torn",
    ];

    protected $casts = [
        'data'  => 'date:d-m-Y',
    ];

    public function carrec() {
        return $this->hasMany('App\Carrec', 'id_carrec', 'id_carrec');
    }

    /*public function carrec() {
        return $this->hasMany(Carrec::class);
    }*/

    public function empleat() {
        return $this->hasMany('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }
}
