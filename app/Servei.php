<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servei extends Model
{
    protected $table = 'slb_serveis';
    protected $primaryKey = 'id_servei';

    protected $fillable = [
        'nom_servei',
        'descripcio_servei'
    ];

    public function registreEntrades()
    {
        return $this->hasMany('App\RegistreEntrada', 'id_servei', 'id_servei');
    }
}
