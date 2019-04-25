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
        $registres = RegistreProduccio::with('traductor')->with('ajustador')
                ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                ->orderBy('estat')->get();
        
        $registreProduccio = array();
        
        foreach ($registres as $registre){
            if ($registre->subreferencia == 0){
                $registreProduccio[$registre->id_registre_entrada] = $registre;
            } else {
                if (!isset($registreProduccio[$registre->id_registre_entrada])){
                    $registreProduccio[$registre->id_registre_entrada][0] = array(
                        'id_registre_entrada' => $registre->id_registre_entrada,
                        'titol' => $registre->registreEntrada->titol
                    );
                }
                $registreProduccio[$registre->id_registre_entrada][$registre->subreferencia] = $registre;
            }
        }
        
        //return response()->json($registreProduccio);
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
        //return response()->json(request()->all());
        if (request()->input("searchBy") == 'id_traductor' || request()->input("searchBy") == 'id_ajustador' || 
            request()->input("searchBy") == 'id_linguista' || request()->input("searchBy") == 'id_director'  || 
            request()->input("searchBy") == 'id_tecnic_mix'){
            //->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')
            if (request()->input("searchBy") == 'id_traductor'){
                $empleats = EmpleatExtern::with(['carrec' => function($query){
                                $query->where('id_tarifa', 12);
                            }])->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
            } else if (request()->input("searchBy") == 'id_ajustador') {
                $empleats = EmpleatExtern::with(['carrec' => function($query){
                                $query->where('id_tarifa', 13);
                            }])->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
            } else if (request()->input("searchBy") == 'id_linguista') {
                $empleats = EmpleatExtern::with(['carrec' => function($query){
                                $query->where('id_tarifa', 14);
                            }])->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
            } else if (request()->input("searchBy") == 'id_director') {
                $empleats = EmpleatExtern::with(['carrec' => function($query){
                                $query->where('id_carrec', 2);
                            }])->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
            } else if (request()->input("searchBy") == 'id_tecnic_mix') {
                $empleats = EmpleatExtern::with(['carrec' => function($query){
                                $query->where('id_carrec', 3);
                            }])->whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
            }
            //return response()->json($empleats);
            foreach ($empleats as $empleat){
                //return response()->json(empty($empleat->carrec[0]));
                if (!empty($empleat->carrec[0])){
                    //return response()->json($empleat);
                    if (!isset($raw)){
                        $raw = request()->input("searchBy").' = '.$empleat->id_empleat.'';
                    } else {
                        $raw = $raw.' OR '.request()->input("searchBy").' = '.$empleat->id_empleat.'';
                    }
                    //return response()->json($empleat);
                }
            }
            if (!isset($raw)){
                $raw = request()->input("searchBy").' like "'.strtolower(request()->input("search_term")).'"';;
            }
            //return response()->json($raw);
            $registreProduccio = RegistreProduccio::with('traductor')->with('ajustador')
                            ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                            ->orderBy('estat')->orderBy('data_entrega')->whereRaw($raw)->paginate(20);
            //return response()->json($registreProduccio);
        } else {
            $registreProduccio = RegistreProduccio::with('traductor')->with('ajustador')
                            ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                            ->orderBy('estat')->orderBy('data_entrega')->whereRaw('LOWER('.request()->input("searchBy").') like "%'.strtolower(request()->input("search_term")).'%"')
                ->paginate(20);
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
        Estadillo::where('id_registre_produccio', request()->input("id"))->delete();
        Costos::where('id_registre_produccio', request()->input("id"))->delete();
        RegistreProduccio::where('id', request()->input("id"))->delete();
        return redirect()->route('indexRegistreProduccio');
    }
}
