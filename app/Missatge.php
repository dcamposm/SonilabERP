<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Missatge extends Model
{
    protected $table = 'slb_missatges';
    protected $primaryKey = 'id_missatge';

    protected $fillable = [
        'id_usuari',
        'missatge',
        'referencia',
        'id_referencia',
        'data_final',
    ];

    public function usuari()
    {
        return $this->belongsTo('App\User', 'id_usuari', 'id_usuari');
    }
    
    public function missatgeNewRegistre($registreEntrada, $registreProduccio)
    {
        $fecha_actual = date("d-m-Y");               
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "NEW";
        $this->referencia ='registreProduccioNew';
        $this->id_referencia =$registreProduccio->id;
        $this->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }
    
    public function missatgeResponsableRegistreCreate($registreEntrada)
    {
        $fecha_actual = date("d-m-Y");          
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "S'ha creat el registre d'entrada: ".$registreEntrada->id_registre_entrada." ".$registreEntrada->titol;
        $this->referencia ='registreEntradaCreate';
        $this->id_referencia =$registreEntrada->id_registre_entrada;
        $this->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }
}
