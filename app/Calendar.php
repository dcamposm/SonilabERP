<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $table = 'slb_calendars';
    protected $primaryKey = 'id_calendar';
    protected $fillable = [
        "id_calendar",
        "id_empleat",
        "id_registre_entrada",
        "numtakes",
        "data_inici",
        "data_fi",
        "num_sala",
    ];

    public function empleatExtern() {
        return $this->hasOne('App\EmpleatExtern','id_empleat','id_empleat');
    }
    public function registreEntrada() {
        return $this->hasOne('App\RegistreEntrada','id_registre_entrada','id_registre_entrada');
    }

}
