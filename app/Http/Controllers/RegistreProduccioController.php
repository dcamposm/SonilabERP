<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmpleatExtern;
use App\RegistreEntrada;

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registresProduccio = array('3838','001','29/09/2018','1','SHANE - THE DISTANT BELL');
        return View('registre_produccio.index', array('registreProduccio' => $registresProduccio));
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
