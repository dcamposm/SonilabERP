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
    //Misstage per indicar un registre nou de producció
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
    //Missatge d'un registre d'entrada creat
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
    //Missatge d'un registre d'entrada modificat
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
    //Missatge de l'entrega d'un registre d'entrada del tipus media Pelicula
    public function missatgeEntregaPeliculaRegistre($registreEntrada, $registreProduccio)
    {             
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "Entrega per el dia ".date("d-m-Y",strtotime($registreEntrada->sortida)). " de la referencia ".$registreEntrada->referencia_titol;
        $this->type = "alertEntrega";
        $this->referencia ='registreProduccio';
        $this->id_referencia =$registreProduccio->id;
        $this->data_final =date("Y-m-d",strtotime($registreEntrada->sortida));
    }
    //Missatge de l'entrega d'un registre d'entrada del tipus media Serie o Documental
    public function missatgeEntregaPackRegistre($registreEntrada, $registreProduccio, $contSet)
    {           
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = "Entrega per el dia ".date("d-m-Y",strtotime($registreProduccio->data_entrega)). " de la referencia ".$registreEntrada->referencia_titol." setmana ".$contSet;
        $this->type = "alertEntrega";
        $this->referencia ='registreEntrada';
        $this->id_referencia =$registreEntrada->id_registre_entrada;
        $this->data_final =date("Y-m-d",strtotime($registreProduccio->data_entrega));
    }
    //Missatge quanr es modifica un actor d'una sala del calendari
    public function missatgeCalendariUpdate($calendari, $id_user)
    {
        $fecha_actual = date("d-m-Y");
        
        $this->id_usuari = $id_user;
        $this->missatge = "S'ha modificat.";
        $this->type = "calendariUpdate";
        $this->referencia = 'calendar';
        $this->id_referencia = $calendari->id_calendar;
        $this->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }
    public function missatgeResponsableRegistreUpdateCamp($registreEntrada, $mod)
    {
        $fecha_actual = date("d-m-Y");          
        $this->id_usuari = $registreEntrada->id_usuari;
        $this->missatge = $mod;
        $this->type = "registreEntradaUpdateCamp";
        $this->referencia ='registreEntrada';
        $this->id_referencia = $registreEntrada->id_registre_entrada;
        $this->data_final = date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
    }
    
}
