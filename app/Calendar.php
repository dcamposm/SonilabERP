<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model {

    protected $table = 'slb_calendars';
    protected $primaryKey = 'id_calendar';
    protected $fillable = [
        "id_actor",
        "id_registre_entrada",
        "setmana",
        "num_takes",
        "data_inici",
        "data_fi",
        "id_calendar_carrec",
        "asistencia",
        "id_director",
        "opcio_calendar",
    ];
    protected $casts = [
        'data_inici'  => 'date:d-m-Y H:i',
        'data_fi'  => 'date:d-m-Y H:i'
    ];
    
    protected $appends = ['referencia_titol'];
    
    public function getReferenciaTitolAttribute() {
        $entrada = RegistreEntrada::with('registreProduccio')->find($this->id_registre_entrada);
        return $entrada->getReferenciaTitolPack($this->setmana);
    }   
    
    public function actor() {
        return $this->belongsTo('App\EmpleatExtern','id_actor','id_empleat');
    }
    
    public function registreEntrada() {
        return $this->belongsTo('App\RegistreEntrada', 'id_registre_entrada', 'id_registre_entrada');
    }
    
    public function director() {
        return $this->hasOne('App\EmpleatExtern','id_empleat','id_director');
    }
    
    public function calendari()
    {
        return $this->belongsTo('App\CalendarCarrec', 'id_calendar_carrec', 'id_calendar_carrec');
    }
}
