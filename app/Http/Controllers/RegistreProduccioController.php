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
        //$empleats = EmpleatExtern::with('produccioTraductor')->get();
        //
        $registreProduccio = RegistreProduccio::with('traductor')->with('ajustador')
                ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                ->orderBy('estat')->orderBy('data_entrega')->get();
        $registreEntrada = RegistreEntrada::all();
        //return response()->json($registreProduccio[0]->getEstadillo);
        return View('registre_produccio.index', array('registreProduccions' => $registreProduccio, 'registreEntrades' => $registreEntrada));
    }

    public function createView() {
        $empleats = EmpleatExtern::with('carrec')->get();
        //return response()->json($empleats);
        // Solamente tenemos que cargar los registros de entrada pendientes.
        $regEntrades = RegistreEntrada::where('estat', '=', 'Pendent')->get();

        return view('registre_produccio.create', array(
            'empleats' => $empleats,
            'regEntrades' => $regEntrades
        ));
    }

    public function show($id) {
        $empleatsCarrec = EmpleatExtern::with('carrec')->get();
        //return response()->json($empleats);
        // Solamente tenemos que cargar los registros de entrada pendientes.
        $regEntrades = RegistreEntrada::where('estat', '=', 'Pendent')->get();
        $registreProduccio = RegistreProduccio::with('registreEntrada')->find($id);
        //return response()->json($registreProduccio);
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
            'empleats'          => $empleados,
            'empleatsCarrec' => $empleatsCarrec,
            'regEntrades' => $regEntrades
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
        $prod = RegistreProduccio::find($id);
        //return response()->json(request()->all());
        $prod->fill(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->back()->with('success', 'Registre de producció modificat correctament.');        
    }
    
    public function updateBasic($id){
        //pongo esto de relleno
        $prod = RegistreProduccio::find($id);

        $v = Validator::make(request()->all(), [
            'id_registre_entrada'    => 'required',
            'subreferencia'          => 'required',
            'data_entrega'           => 'required',
            'setmana'                => 'required',
            'titol'                  => 'required',
            'estat'                  => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
        getIndex();
        
    }

    public function updateComanda($id){
        //pongo esto de relleno
        $prod = RegistreProduccio::find($id);

        $v = Validator::make(request()->all(), [
            'estadillo'         => 'required',
            'propostes'         => 'required',
            'inserts'           => 'required',
            'vec'               => 'required',
            'data_tecnic_mix'       => 'date',            
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
        getIndex();
        
    }
    
    public function updatePreparacio($id){
        //pongo esto de relleno
        $prod = RegistreProduccio::find($id);

        $v = Validator::make(request()->all(), [
            'qc_vo'                 => 'required',
            'qc_me'                 => 'required',
            'qc_mix'                => 'required',
            'ppp'                   => 'required',
            'pps'                   => 'required',
            'ppe'                   => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
            'date' => 'Aquesta dada te que ser una data.'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
        getIndex();
        
    }

    public function updateConvocatoria($id){

        $prod = RegistreProduccio::find($id);
        //return response()->json($prod);
        $v = Validator::make(request()->all(), [
            'convos'            => 'required',
            'inici_sala'        => 'date',
            'final_sala'        => 'date',
            'retakes'           => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
            'date' => 'Aquesta dada te que ser una data.'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
        getIndex();
        
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

        return view('registre_produccio.index', array('registreProduccions' => $registreProduccio,
                                                        'return' => 1));
    }

    public function createBasic(){
        $v = Validator::make(request()->all(), [
            'id_registre_entrada'    => 'required',
            'subreferencia'          => 'required',
            'data_entrega'           => 'required',
            'setmana'                => 'required',
            'titol'                  => 'required',
            'estat'                  => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
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
            'estadillo'         => 'required',
            'propostes'         => 'required',
            'inserts'           => 'required',
            'titol_traduit'     => 'required',
            'vec'               => 'required',
            'data_tecnic_mix'       => 'date',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
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
            'qc_vo'                 => 'required',
            'qc_me'                 => 'required',
            'qc_mix'                => 'required',
            'ppp'                   => 'required',
            'pps'                   => 'required',
            'ppe'                   => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
            'date' => 'Aquesta dada te que ser una data.'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
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
            'inici_sala'        => 'date',
            'final_sala'        => 'date',
            'retakes'           => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
            'date' => 'Aquesta dada te que ser una data.'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
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

    public function delete(Request $request) {
        RegistreProduccio::where('id', request()->input("id"))->delete();
        return redirect()->route('indexRegistreProduccio');
    }
}
