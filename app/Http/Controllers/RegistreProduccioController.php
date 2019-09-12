<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\{RegistreProduccio, EmpleatExtern, Missatge, Estadillo, Costos, RegistreEntrada,ActorEstadillo,EmpleatCost};
use App\Http\Responsables\RegistreProduccio\{RegistreProduccioIndex, RegistreProduccioCreate, RegistreProduccioShow};
use App\Http\Requests\{RegistreProduccioCreateRequest, RegistreProduccioUpdateRequest};

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registres = RegistreProduccio::orderBy('estat', 'asc')->orderBy('data_entrega', 'asc')->get();

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
        
        RegistreProduccioController::missatgesUpdate($prod);
        
        try {
            $prod->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar.'));
        }

        return redirect()->route('indexRegistreProduccio')->with('success', 'Registre de producció modificat correctament.');        
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
                            ->orderBy(request()->input("orderBy"))->whereRaw($raw)->get();
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
                        ->orderBy(request()->input("orderBy"))->whereRaw(!isset($raw) ? 0 : $raw)->get();
        } else {
            $registres = RegistreProduccio::with('traductor')->with('ajustador')
                ->with('linguista')->with('director')->with('tecnic')->with('getEstadillo')
                ->orderBy(request()->input("orderBy"))->whereRaw('LOWER('.request()->input("searchBy").') like "%'.strtolower(request()->input("search_term")).'%"')
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

    public function delete() {
        ActorEstadillo::join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                        ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                        ->where('slb_registres_produccio.id', request()->input("id"))
                        ->delete();

        Estadillo::where('id_registre_produccio', request()->input("id"))->delete();
        
        EmpleatCost::join('slb_costos', 'slb_costos.id_costos', 'slb_empleats_costos.id_costos')
                        ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_costos.id_registre_produccio')
                        ->where('slb_registres_produccio.id', request()->input("id"))
                        ->delete();
        
        Costos::where('id_registre_produccio', request()->input("id"))->delete();
        RegistreProduccio::where('id', request()->input("id"))->delete();
        
        return redirect()->route('indexRegistreProduccio');
    }
    
    public function search()
    {
        $registreProduccio = RegistreProduccio::all();
        
        return response()->json($registreProduccio);
    }
    
    public function missatgesUpdate($referencia)
    {
        foreach (request()->input() as $key => $request) {
            if ($key != '_token') {
                switch ($key) {
                    case 'data_traductor':
                        $missatge = Missatge::firstOrNew(['id_referencia' => $referencia->id, 'referencia' => 'registreProduccio', 'type' => 'alertEntregaTraduccio']);
                        $missatge->missatgeAlertaEntregaProduccio($referencia, 'de la traducció','Traduccio', $referencia->data_traductor);
                        $missatge->save();
                    break;
                    case 'data_ajustador':
                        $missatge = Missatge::firstOrNew(['id_referencia' => $referencia->id, 'referencia' => 'registreProduccio', 'type' => 'alertEntregaAjust']);
                        $missatge->missatgeAlertaEntregaProduccio($referencia, "de l'ajust",'Ajust', $referencia->data_ajustador);
                        $missatge->save();
                    break;
                    case 'data_linguista':
                        $missatge = Missatge::firstOrNew(['id_referencia' => $referencia->id, 'referencia' => 'registreProduccio', 'type' => 'alertEntregaCorreccio']);
                        $missatge->missatgeAlertaEntregaProduccio($referencia, 'de la correcció','Correccio', $referencia->data_linguista);
                        $missatge->save();
                    break;
                    case 'inici_sala':
                        $missatge = Missatge::firstOrNew(['id_referencia' => $referencia->id, 'referencia' => 'registreProduccio', 'type' => 'alertIniciSala']);
                        $missatge->missatgeAlertaIniciSala($referencia);
                        $missatge->save();
                    break;
                    case 'data_tecnic_mix':
                        $missatge = Missatge::firstOrNew(['id_referencia' => $referencia->id, 'referencia' => 'registreProduccio', 'type' => 'alertIniciSala']);
                        $missatge->missatgeAlertaDataMix($referencia);
                        $missatge->save();
                    break;
                }
            } 
        }
        
        return ;
    }
}
