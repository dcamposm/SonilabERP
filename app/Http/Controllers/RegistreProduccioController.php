<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegistreEntrada;
use App\RegistreProduccio;
use App\EmpleatExtern;

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registreProduccio = RegistreProduccio::all();
        return View('registre_produccio.index', array('registreProduccions' => $registreProduccio));
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
    
    public function show($id){
        $registreEntrada = RegistreEntrada::find($id);
        $idioma = Idioma::find($registreEntrada['id_idioma']);
        $client = Client::find($registreEntrada['id_client']);
        $servei = Servei::find($registreEntrada['id_servei']);
        $media = TipusMedia::find($registreEntrada['id_media']);
        return view('registre_entrada.show', array(
            'registreEntrada' => $registreEntrada,
            'client'          => $client,
            'servei'          => $servei,
            'media'           => $media,
            'idioma'          => $idioma
        ));
    }

}
