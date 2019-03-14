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
        $registreEntrada = RegistreEntrada::all();
        return View('registre_produccio.index', array('registreProduccions' => $registreProduccio, 'registreEntrades' => $registreEntrada));
    }

    public function createView() {
        $empleats = EmpleatExtern::all();
        // Solamente tenemos que cargar los registros de entrada pendientes.
        $regEntrades = RegistreEntrada::where('estat', '=', 'Pendent')->get();

        return view('registre_produccio.create', array(
            'empleats' => $empleats,
            'regEntrades' => $regEntrades
        ));
    }

    public function show($id) {
        $registreProduccio = RegistreProduccio::find($id);

        return view('registre_produccio.show', array(
            'registreProduccio' => $registreProduccio
        ));
    }

    public function find() {
        if (request()->input("searchBy") == '3') {
            $registreProduccio = RegistreProduccio::where('estat', request()->input("search_Estat"))->get();
        } else if (request()->input("searchBy") == '2') {
            $registreProduccio = RegistreEntrada::where('estat', request()->input("search_Estat"))->get();
        } else {
            $registreProduccio = RegistreEntrada::where('titol', request()->input("search_term"))
                            ->orWhere('id_registre_entrada', request()->input("search_term"))->get();
        }

        return view('registre_produccio.index', array('registreProduccions' => $registreProduccio));
    }

}
