<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegistreEntrada;
use App\RegistreProduccio;
use App\EmpleatExtern;
use App\Missatge;
use App\Rules\CheckSubreferenciaCreate;
use App\Rules\CheckSubreferenciaUpdate;
use Auth;
use Validator;
use App\Http\Responsables\RegistreProduccio\RegistreProduccioIndex;
use App\Http\Responsables\RegistreProduccio\RegistreProduccioCreate;
use App\Http\Responsables\RegistreProduccio\RegistreProduccioShow;
use App\Http\Requests\RegistreProduccioCreateRequest;
use App\Estadillo;
use App\Costos;

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registres = RegistreProduccio::orderBy('data_entrega')->get();

        return new RegistreProduccioIndex($registres);
    }

    public function createView() {
        return new RegistreProduccioCreate();
    }

    public function show($id) {
        $registreProduccio = RegistreProduccio::with('registreEntrada')->find($id);
        
//----------Si entra el reponsable del registre d'entrada i el registre te un missatge NEW, elimina el missatge---------------
        if ($registreProduccio->registreEntrada->id_usuari == Auth::user()->id_usuari){
            Missatge::where([['id_referencia', $id],
                            ['missatge', 'NEW'],
                            ['referencia', 'registreProduccio']])                   
                            ->delete();
        }
        
        return new RegistreProduccioShow($registreProduccio);
    }

    public function updateView($id){
        $registreProduccio = RegistreProduccio::find($id);
        
        return new RegistreProduccioCreate($registreProduccio);
    }
    
    public function update($id){
        $prod = RegistreProduccio::find($id);
        
        if (request()->input('subreferencia')){
            if ($prod->subreferencia != request()->input('subreferencia')){
                $registre = RegistreProduccio::where('id_registre_entrada', $prod->id_referencia_entrada)
                        ->whereSubreferencia(request()->input('subreferencia'))->first();
                
                if (!$registre){
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar. No es pot repetir subreferencies.'));
                }
            }
        }
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
            'subreferencia'          => ['required', new CheckSubreferenciaUpdate($prod, request()->input('id_registre_entrada'), request()->input('subreferencia'))],
            'data_entrega'           => 'required',
            'setmana'                => 'required',
            'titol'                  => 'required',
            'estat'                  => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
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
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
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
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
    }

    public function updateConvocatoria($id){

        $prod = RegistreProduccio::find($id);
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
        } else {
            $prod->fill(request()->all());               

            try {
                $prod->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
            }

            return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
        }
    }

    public function find() {
        if (request()->input("searchBy") == 'id_traductor' || request()->input("searchBy") == 'id_ajustador' || 
            request()->input("searchBy") == 'id_linguista' || request()->input("searchBy") == 'id_director'  || 
            request()->input("searchBy") == 'id_tecnic_mix'){
            
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

            foreach ($empleats as $empleat){
                if (!empty($empleat->carrec[0])){
                    if (!isset($raw)){
                        $raw = request()->input("searchBy").' = '.$empleat->id_empleat.'';
                    } else {
                        $raw = $raw.' OR '.request()->input("searchBy").' = '.$empleat->id_empleat.'';
                    }
                }
            }
            if (!isset($raw)){
                $raw = request()->input("searchBy").' like "'.strtolower(request()->input("search_term")).'"';;
            }

            $registres = RegistreProduccio::with('traductor')->with('ajustador')
                            ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                            ->orderBy('estat')->orderBy('data_entrega')->orderBy(request()->input("orderBy"))->whereRaw($raw)->get();
        } else {
            $registres = RegistreProduccio::with('traductor')->with('ajustador')
                ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                ->orderBy('estat')->orderBy('data_entrega')->orderBy(request()->input("orderBy"))->whereRaw('LOWER('.request()->input("searchBy").') like "%'.strtolower(request()->input("search_term")).'%"')
                ->get();
        }

        return new RegistreProduccioIndex($registres);
    }

    public function createBasic(RegistreProduccioCreateRequest $request){
        $prod = new RegistreProduccio(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
        }

        return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
    }

    public function createComanda(RegistreProduccioCreateRequest $request){
        $prod = new RegistreProduccio(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
        }

        return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
    }

    public function createPreparacio(RegistreProduccioCreateRequest $request){
        $prod = new RegistreProduccio(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
        }

        return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
    }

    public function createConvocatoria(RegistreProduccioCreateRequest $request){
        $prod = new RegistreProduccio(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el client.'));
        }

        return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció creat correctament.');
    }

    public function delete(Request $request) {
        Estadillo::where('id_registre_produccio', request()->input("id"))->delete();
        Costos::where('id_registre_produccio', request()->input("id"))->delete();
        RegistreProduccio::where('id', request()->input("id"))->delete();
        return redirect()->route('indexRegistreProduccio');
    }
}
