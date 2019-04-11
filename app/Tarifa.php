<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'slb_tarifas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "nombre",
        "id_carrec",
        "nombre_corto"
    ];
    
    public function carrecs()
    {
        return $this->hasMany('App\CarrecEmpleat', 'id_carrec', 'id_carrec');
    }
    
    public function carrec()
    {
        return $this->belongsTo('App\Carrec', 'id_carrec', 'id_carrec');
    }
    
    public function costos()
    {
        return $this->hasMany('App\EmpleatCostos', 'id', 'id_tarifa');
    }
}
