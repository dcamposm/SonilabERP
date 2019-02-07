<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarrecEmpleat extends Model
{
    protected $table = 'slb_carrecs_empleats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleat',
        'id_carrec',
        'id_idioma',
        'empleat_homologat',
        'preu_carrec',
        'id_tarifa'
    ];

    public function empleat()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }

    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'id_idioma', 'id_idioma');
    }

    public function carrec()
    {
        return $this->belongsTo('App\Carrec', 'id_carrec', 'id_carrec');
    }
    
    public function tarifa()
    {
        return $this->belongsTo('App\Tarifa', 'id_tarifa', 'id');
    }
}
