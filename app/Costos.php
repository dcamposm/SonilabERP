<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Costos extends Model
{
    protected $table = 'slb_costos';
    protected $primaryKey = 'id_costos';

    public  $fillable = [ 
        "id_registre_produccio",
        "cost_total",
        "preu_venda"
    ];

    public function empleats()
    {
        return $this->hasMany('App\EmpleatCost', 'id_costos', 'id_costos');
    }
    
    public function registreProduccio()
    {
            return $this->hasOne('App\RegistreProduccio', 'id', 'id_registre_produccio');
    }
}
