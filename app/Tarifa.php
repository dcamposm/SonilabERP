<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'slb_tarifas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "nombre"
    ];
    
    public function carrecs()
    {
        return $this->hasMany('App\CarrecEmpleat', 'id', 'id_tarifa');
    }
}
