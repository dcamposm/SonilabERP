<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use App\RegistreEntrada;
use App\RegistreProduccio;
=======
use App\EmpleatExtern;
use App\RegistreEntrada;
>>>>>>> 02b80ac59b3c527381c16281bd12bec726578d47

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

    public function createView() {
        $empleats    = EmpleatExtern::all();
        // Solamente tenemos que cargar los registros de entrada pendientes.
        $regEntrades = RegistreEntrada::where('estat', '=', 'Pendent')->get();

        return view('registre_produccio.create', array(
            'empleats'    => $empleats,
            'regEntrades' => $regEntrades
        ));
    }

}
