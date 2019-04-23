<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleatCost extends Model
{
    protected $table = 'slb_empleats_costos';
    protected $primaryKey = 'id';

    protected $fillable = [
        "id_costos",
        "id_empleat",
        "id_tarifa",
        "cost_empleat", 
    ];

    public function empleat()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }
    
   public function tarifa()
    {
        return $this->belongsTo('App\Tarifa', 'id_tarifa', 'id');
    }
    
    public function cost()
    {
        return $this->belongsTo('App\Costos', 'id_costos', 'id_costos');
    }
}
