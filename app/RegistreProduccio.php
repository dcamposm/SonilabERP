<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistreProduccio extends Model
{
    protected $table = 'slb_registres_produccio';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subreferencia',
        'id_registre_entrada',
        'data_entrega',
        'setmana',
        'titol',
        'titol_traduit',
        'qc_vo',
        'qc_me',
        'ppp',
        'id_traductor',
        'data_traductor',
        'id_ajustador',
        'data_ajustador',
        'id_linguista',
        'data_linguista',
        'id_director',
        'casting',
        'propostes',
        'inserts',
        'estadillo',
        'vec',
        'convos',
        'inici_sala',
        'pps',
        'final_sala',
        'id_tecnic_mix',
        'data_tecnic_mix',
        'retakes',
        'qc_mix',
        'ppe',
        'estat'
    ];
       
    public function getEstadillo()
    {
        return $this->belongsTo('App\Estadillo', 'id', 'id_registre_produccio');
    }
    
    public function getVec()
    {
        return $this->belongsTo('App\Costos', 'id', 'id_registre_produccio');
    }

    public function registreEntrada()
    {
        return $this->belongsTo('App\RegistreEntrada', 'id_registre_entrada', 'id_registre_entrada');
    }
    
    public function traductor()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_traductor', 'id_empleat');
    }
    
    public function ajustador()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_ajustador', 'id_empleat');
    }
    
    public function linguista()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_linguista', 'id_empleat');
    }
    
    public function director()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_director', 'id_empleat');
    }
    
    public function tecnic()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_tecnic_mix', 'id_empleat');
    }
    
    public function createRegistrePelicula($registreEntrada)
    {
        $this->subreferencia = 0;
        $this->id_registre_entrada = $registreEntrada->id_registre_entrada;
        $this->data_entrega = $registreEntrada->sortida;
        $this->setmana = 1;
        $this->titol = $registreEntrada->titol;
    }
}
