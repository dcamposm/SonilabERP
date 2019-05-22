<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\{RegistreProduccio, EmpleatExtern, Missatge, Estadillo, Costos, RegistreEntrada};
use App\Http\Responsables\RegistreProduccio\{RegistreProduccioIndex, RegistreProduccioCreate, RegistreProduccioShow};
use App\Http\Requests\{RegistreProduccioCreateRequest, RegistreProduccioUpdateRequest};

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
    //Update de la vista Show    
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
    
    public function updateBasic(RegistreProduccioUpdateRequest $request, $id){
        $prod = RegistreProduccio::find($id);

        $prod->fill(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
    }

    public function updateComanda(RegistreProduccioUpdateRequest $request, $id){
        //pongo esto de relleno
        $prod = RegistreProduccio::find($id);

        $prod->fill(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
    }
    
    public function updatePreparacio(RegistreProduccioUpdateRequest $request, $id){
        //pongo esto de relleno
        $prod = RegistreProduccio::find($id);

        $prod->fill(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
    }

    public function updateConvocatoria(RegistreProduccioUpdateRequest $request, $id){

        $prod = RegistreProduccio::find($id);

        $prod->fill(request()->all());               

        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->back()->with('success', 'Registre de producció modificat correctament.');
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
        } else if (request()->input("searchBy") == 'responsable'){
            $registresEntrades = RegistreEntrada::where('id_usuari', request()->input("search_term"))->get();

            foreach ($registresEntrades as $regEntrada){
                if (!isset($raw)){
                    $raw = 'id_registre_entrada = '.$regEntrada->id_registre_entrada.'';
                } else {
                    $raw = $raw.' OR id_registre_entrada = '.$regEntrada->id_registre_entrada.'';
                }
            }
            
            $registres = RegistreProduccio::with('traductor')->with('ajustador')
                        ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                        ->orderBy('estat')->orderBy('data_entrega')->orderBy(request()->input("orderBy"))->whereRaw(!isset($raw) ? 0 : $raw)->get();
            //return response()->json($registres);
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
