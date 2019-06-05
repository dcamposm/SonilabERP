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
        'type',
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
        $this->type = "new";
        $this->referencia ='registreProduccio';
        $this->id_referencia =$registreProduccio->id;
        $this->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }
    
    public function missatgeResponsableRegistreCreate($registreEntrada)
    {
        $fecha_actual = date("d-m-Y");          
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "S'ha creat el registre d'entrada: ".$registreEntrada->referencia_titol;
        $this->type = "registreEntradaCreate";
        $this->referencia ='registreEntrada';
        $this->id_referencia =$registreEntrada->id_registre_entrada;
        $this->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }

    public function missatgeResponsableRegistreUpdate($registreEntrada)
    {
        $fecha_actual = date("d-m-Y");          
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "S'ha modificat el registre d'entrada: ".$registreEntrada->referencia_titol;
        $this->type = "registreEntradaUpdate";
        $this->referencia ='registreEntrada';
        $this->id_referencia = $registreEntrada->id_registre_entrada;
        $this->data_final = date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }

    public function missatgeEntregaPeliculaRegistre($registreEntrada, $registreProduccio)
    {
        $fecha_actual = date("d-m-Y");               
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "Entrega per el dia ".date("d-m-Y",strtotime($registreEntrada->sortida)). " de la referencia ".$registreEntrada->referencia_titol;
        $this->type = "alertEntrega";
        $this->referencia ='registreProduccio';
        $this->id_referencia =$registreProduccio->id;
        $this->data_final =date("Y-m-d",strtotime($registreEntrada->sortida));
    }

    public function missatgeEntregaPackRegistre($registreEntrada, $registreProduccio, $contSet)
    {
        $fecha_actual = date("d-m-Y");               
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "Entrega per el dia ".date("d-m-Y",strtotime($registreProduccio->data_entrega)). " de la referencia ".$registreEntrada->referencia_titol." setmana ".$contSet;
        $this->type = "alertEntrega";
        $this->referencia ='registreEntrada';
        $this->id_referencia =$registreEntrada->id_registre_entrada;
        $this->data_final =date("Y-m-d",strtotime($registreProduccio->data_entrega));
    }
}
