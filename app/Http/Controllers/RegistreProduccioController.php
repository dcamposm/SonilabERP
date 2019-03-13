<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegistreEntrada;
use App\RegistreProduccio;

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registresProduccio = array('3838','001','29/09/2018','1','SHANE - THE DISTANT BELL');
        return View('registre_produccio.index', array('registreProduccio' => $registresProduccio));
    }
    
    public function insertView(){
        //Esto es temporal porque obviamente no mostraremos un desplegable con todos los registros de entrada.
        $registreEntrada = RegistreEntrada::all();
        $registreProduccio = RegistreProduccio::all();
        
        return View('registre_produccio.create', array('registresEntrada'=>$registreEntrada,'registreProducció'=>$registreProduccio));
    }

}
