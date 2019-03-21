<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegistreEntrada;
use App\RegistreProduccio;
use App\EmpleatExtern;
use Validator;

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

        $empleados   = [];
        $traductor   = EmpleatExtern::find($registreProduccio["id_traductor"]);
        $ajustador   = EmpleatExtern::find($registreProduccio->id_ajustador);
        $linguista   = EmpleatExtern::find($registreProduccio->id_linguista);
        $director    = EmpleatExtern::find($registreProduccio->id_director);
        $tecnic_mix  = EmpleatExtern::find($registreProduccio->id_tecnic_mix);

        if ($traductor) $empleados["traductor"] = $traductor;
        if ($ajustador) $empleados["ajustador"] = $ajustador;
        if ($linguista) $empleados["linguista"] = $linguista;
        if ($director) $empleados["director"] = $director;
        if ($tecnic_mix) $empleados["tecnic_mix"] = $tecnic_mix;

        return view('registre_produccio.show', array(
            'registreProduccio' => $registreProduccio,
            'empleats'          => $empleados
        ));
    }

    public function updateView($id){
        $registreProduccio = RegistreProduccio::find($id);
        $empleats = EmpleatExtern::all();
        $regEntrades = RegistreEntrada::where('estat', '=', 'Pendent')->get();

        return view('registre_produccio.create', array(
            'registreProduccio' => $registreProduccio,
            'empleats'          => $empleats,
            'regEntrades'       => $regEntrades
        ));
    }
    
    public function update($id){
        //pongo esto de relleno
        $registreProduccio = RegistreProduccio::all();
        $registreEntrada = RegistreEntrada::all();
        return View('registre_produccio.index', array('registreProduccions' => $registreProduccio, 'registreEntrades' => $registreEntrada));
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

    public function createBasic(){
        $v = Validator::make(request()->all(), [
            'id_registre_entrada'            => 'required',
            'subreferencia'          => 'required',
            'data_entrega'        => 'required',
            'setmana'       => 'required',
            'titol'    => 'required',
            'titol_traduit'         => 'required',
            //'data_mix'           => 'required',
            'estat'         => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod = new RegistreProduccio(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
        }
    }

    public function createComanda(){
        $v = Validator::make(request()->all(), [
            'estadillo'            => 'required',
            'propostes'          => 'required',
            'retakes'        => 'required',
            'subtitol'       => 'required',
            'qc_mix'    => 'required',
            'ppe'         => 'required',
            
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod = new RegistreProduccio(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
        }
    }

    public function createEmpleats(){
        $v = Validator::make(request()->all(), [
            'id_traductor'            => 'required',
            'data_traductor'          => 'required',
            'id_ajustador'        => 'required',
            'data_ajustador'       => 'required',
            'id_linguista'    => 'required',
            'data_linguista'         => 'required',
            'id_tecnic_mix'           => 'required',
            'data_tecnic_mix'         => 'required',
            'id_director'         => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod = new RegistreProduccio(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
        }
    }

    public function createPreparacio(){
        $v = Validator::make(request()->all(), [
            'qc_vo'            => 'required',
            'qc_me'          => 'required',
            'ppp'        => 'required',
            'casting'       => 'required',
            'inserts'    => 'required',
            'vec'         => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod = new RegistreProduccio(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
        }
    }

    public function createConvocatoria(){
        $v = Validator::make(request()->all(), [
            'convos'            => 'required',
            'inici_sala'          => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod = new RegistreProduccio(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
            }

            return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
        }
    }

    public function delete() {
        RegistreProduccio::where('id', request()->input("id"))->delete();
        return redirect()->route('indexRegistreProduccio');
    }



}
