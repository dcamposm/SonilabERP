<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrec extends Model
{
    protected $table = 'slb_carrecs';
    protected $primaryKey = 'id_carrec';

    protected $fillable = [
        'nom_carrec',
        'descripcio_carrec'
    ];

    public function carrecEmpleat()
    {
        return $this->hasMany('App\CarrecEmpleat', 'id_carrec', 'id_carrec');
    }
    
    public function tarifa()
    {
        return $this->hasMany('App\Tarifa', 'id_carrec', 'id_carrec');
    }
}
