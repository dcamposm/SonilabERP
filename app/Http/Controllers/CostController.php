<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Costos;
use App\RegistreProduccio;
use App\EmpleatCost;
use Validator;
class CostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $costos = Costos::with('registreProduccio.registreEntrada.client')->get();
        $registreProduccio = RegistreProduccio::all();
        
        $arrayProjectes = array();
        $cont = 0;
        $exist = false;
        
        foreach ($registreProduccio as $projecte){
            foreach ($costos as $vec) {
                if ($projecte->id == $vec->id_registre_produccio){
                    $exist = true;
                }
            }
            if ($exist == false) {
                $arrayProjectes[$cont] = $projecte;
                $cont++;
            } else {
                $exist = false;
            }
        }
        //return response()->json($costos);
        return View('vec.index', array('costos' => $costos, 'registreProduccio' => $arrayProjectes));
    }
    
    public function show($id)
    {
        $vec = Costos::with('registreProduccio.registreEntrada.client')->with('empleats.tarifa')->find($id);
        $total = 0;
        //return response()->json($vec);
        $empleatsInfo = array();
        foreach ($vec->empleats as $empleat){
            if ($empleat->tarifa->carrec->nom_carrec == 'Actor'){
                if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                        'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                        'tk' => 0,
                        'cg' => 0,
                        'total' => $empleat->cost_empleat
                    );
                    $total += $empleat->cost_empleat;
                    //return response()->json($empleatsInfo);
                    foreach ($empleat->empleat->estadillo as $actor){
                        if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){
                            
                            $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                            $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo;
                            //return response()->json($empleatsInfo);
                        }
                    }
                } else {
                    $total += $empleat->cost_empleat;
                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                } 
            } else {
                if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                        'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                        'tasca' => array(),
                        'total' => $empleat->cost_empleat
                    );
                    $total += $empleat->cost_empleat;
                    if ($empleat->tarifa->carrec->nom_carrec == 'Traductor') array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->nombre_corto);
                    else array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->carrec->nom_carrec);
                } else {
                    $total += $empleat->cost_empleat;
                    //return response()->json($empleat->tarifa->nombre_corto);
                    if ($empleat->tarifa->carrec->nom_carrec == 'Traductor') array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->nombre_corto);
                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                } 
            }
        }
        //return response()->json($empleatsInfo);
        return View('vec.show', array('vec' => $vec, 'empleatsInfo' => $empleatsInfo, 'total' => $total));
    }
    
    public function generar($id)
    {
        $registre = RegistreProduccio::with('getEstadillo.actors.empleat.carrec')->with('traductor.carrec')
                ->with('ajustador')->with('linguista')->with('director')->with('tecnic')
                ->with('registreEntrada')->find($id);
        //return response()->json($registre);
        $vec = Costos::where('id_registre_produccio', $id)->first();
        if (!$vec){
            $vec = new Costos();
            $vec->id_registre_produccio = $id;
            $vec->save();
            
            //----------------------Costos Actors---------------------------------
            if ($registre->getEstadillo != null){
                if (!empty($registre->getEstadillo->actors)){
                    foreach ($registre->getEstadillo->actors as $actor){
                        //$cost = 0;
                        //$empleatCost->cost_empleat = ;
                        if ($registre->registreEntrada->id_servei == 1){
                            foreach ($actor->empleat->carrec as $actorCarrec){
                                $empleatCost = new EmpleatCost();
                                $empleatCost->id_costos = $vec->id_costos;
                                $empleatCost->id_empleat = $actor->id_actor;
                                if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && 
                                        ($actorCarrec->tarifa->nombre_corto == 'video_take' || $actorCarrec->tarifa->nombre_corto == 'video_cg') && $actorCarrec->preu_carrec != 0){

                                    if ($actorCarrec->tarifa->nombre_corto == 'video_take') {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        $empleatCost->id_tarifa = 5;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $empleatCost->id_tarifa = 6;
                                        $empleatCost->save();
                                    }
                                }
                            }                           
                        } else {
                            foreach ($actor->carrec as $actorCarrec){
                                $empleatCost = new EmpleatCost();
                                $empleatCost->id_costos = $vec->id_costos;
                                $empleatCost->id_empleat = $actor->id_actor;
                                if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && 
                                        ($actorCarrec->tarifa->nombre_corto == 'cine_take'|| $actorCarrec->tarifa->nombre_corto == 'cine_cg') && $actorCarrec->preu_carrec != 0){

                                    if ($actorCarrec->tarifa->nombre_corto == 'cine_take') {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        $empleatCost->id_tarifa = 7;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $empleatCost->id_tarifa = 8;
                                        $empleatCost->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //-----------------------Costos Traductor-------------------
            if ($registre->traductor != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->traductor->id_empleat;
                
                foreach ($registre->traductor->carrec as $empleatCarrec){
                    if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'traductor' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 12;
                        $empleatCost->save();
                    }
                }

                
            }
            //-----------------------Costos Ajustador-------------------
            if ($registre->ajustador != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->ajustador->id_empleat;
                foreach ($registre->ajustador->carrec as $empleatCarrec){
                    if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'ajustador' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 13;
                        $empleatCost->save();
                    }
                }

            }
            //-----------------------Costos Ajustador-------------------
            if ($registre->linguista != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->linguista->id_empleat;
                foreach ($registre->linguista->carrec as $empleatCarrec){
                    if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'linguista' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 14;
                        $empleatCost->save();
                    }
                }

                
            }
            //-----------------------Costos Director-------------------
            if ($registre->director != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->director->id_empleat;
                foreach ($registre->director->carrec as $empleatCarrec){
                    if ($empleatCarrec->tarifa->nombre_corto == 'rotllo' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 1;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'minut' && $empleatCarrec->preu_carrec != 0 ){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 2;
                        $empleatCost->save();
                    }
                    
                }

                
            }
            //-----------------------Costos Tecnic-------------------
            if ($registre->tecnic != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->tecnic->id_empleat;
                foreach ($registre->tecnic->carrec as $empleatCarrec){
                    if ($empleatCarrec->tarifa->nombre_corto == 'sala' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 3;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'mix' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $empleatCost->id_tarifa = 4;
                        $empleatCost->save();
                    }
                }

                
            }
            
            $registre->vec = 1;
            $registre->save();
        }
        
        //return response()->json($registre);
        return redirect()->route('indexVec');
    }
    
    public function insert()
    {
        //return response()->json(request()->all());
        $v = Validator::make(request()->all(), [
            'id_registre_produccio'   => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            
            if (RegistreProduccio::find(request()->input('id_registre_produccio'))){
                $registre = RegistreProduccio::with('getEstadillo.actors.empleat.carrec')->with('traductor.carrec')
                ->with('ajustador')->with('linguista')->with('director')->with('tecnic')
                ->with('registreEntrada')->find(request()->input('id_registre_produccio'));
                //return response()->json($registre);
                $vec = new Costos;
                
                $vec->id_registre_produccio=request()->input('id_registre_produccio');
                
                try {
                    $vec->save();
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }
                
                $registre->vec = 1;
                
                //----------------------Costos Actors---------------------------------
                if ($registre->getEstadillo != null){
                    if (!empty($registre->getEstadillo->actors)){
                        foreach ($registre->getEstadillo->actors as $actor){
                            $cost = 0;
                            $empleatCost = new EmpleatCost();
                            $empleatCost->id_costos = $vec->id_costos;
                            $empleatCost->id_empleat = $actor->id_actor;
                            //$empleatCost->cost_empleat = ;
                            if ($registre->registreEntrada->id_servei == 1){
                                foreach ($actor->empleat->carrec as $actorCarrec){
                                    if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && 
                                            ($actorCarrec->id_tarifa == 5 || $actorCarrec->id_tarifa == 6)){

                                        if ($actorCarrec->id_tarifa == 5) {
                                            $cost += $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        } else {
                                            $cost += $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        }
                                    }
                                }                           
                            } else {
                                foreach ($actor->carrec as $actorCarrec){
                                    if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && 
                                            ($actorCarrec->id_tarifa == 7 || $actorCarrec->id_tarifa == 8)){

                                        if ($actorCarrec->id_tarifa == 7) {
                                            $cost += $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        } else {
                                            $cost += $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        }
                                    }
                                }
                            }
                            $empleatCost->cost_empleat = $cost;
                            $empleatCost->save();
                        }
                    }
                }
                //-----------------------Costos Traductor-------------------
                if ($registre->traductor != null){
                    $cost = 0;

                    $id_costos = $vec->id_costos;
                    $id_empleat = $registre->traductor->id_empleat;
                    foreach ($registre->traductor->carrec as $empleatCarrec){
                        if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->id_tarifa == 12){
                            $cost += $empleatCarrec->preu_carrec;
                        }
                    }
                    $empleatCost = EmpleatCost::firstOrCreate(['id_costos' => $id_costos, 'id_empleat' => $id_empleat]);
                    //return response()->json($empleatCost);
                    $empleatCost->cost_empleat += $cost;
                    $empleatCost->save();
                }
                //-----------------------Costos Ajustador-------------------
                if ($registre->ajustador != null){
                    $cost = 0;

                    $id_costos = $vec->id_costos;
                    $id_empleat = $registre->ajustador->id_empleat;
                    foreach ($registre->ajustador->carrec as $empleatCarrec){
                        if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->id_tarifa == 13){
                            $cost += $empleatCarrec->preu_carrec;
                        }
                    }
                    $empleatCost = EmpleatCost::firstOrCreate(['id_costos' => $id_costos, 'id_empleat' => $id_empleat]);
                    //return response()->json($empleatCost);
                    $empleatCost->cost_empleat += $cost;
                    $empleatCost->save();
                }
                //-----------------------Costos Ajustador-------------------
                if ($registre->linguista != null){
                    $cost = 0;

                    $id_costos = $vec->id_costos;
                    $id_empleat = $registre->linguista->id_empleat;
                    foreach ($registre->linguista->carrec as $empleatCarrec){
                        if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->id_tarifa == 14){
                            $cost += $empleatCarrec->preu_carrec;
                        }
                    }
                    $empleatCost = EmpleatCost::firstOrCreate(['id_costos' => $id_costos, 'id_empleat' => $id_empleat]);
                    //return response()->json($empleatCost);
                    $empleatCost->cost_empleat += $cost;
                    $empleatCost->save();
                }
                //-----------------------Costos Director-------------------
                if ($registre->director != null){
                    $cost = 0;

                    $id_costos = $vec->id_costos;
                    $id_empleat = $registre->director->id_empleat;
                    foreach ($registre->director->carrec as $empleatCarrec){
                        if ($empleatCarrec->id_tarifa == 1){
                            $cost += $empleatCarrec->preu_carrec;
                        } else if ($empleatCarrec->id_tarifa == 2){
                            $cost += $empleatCarrec->preu_carrec;
                        }
                    }
                    $empleatCost = EmpleatCost::firstOrCreate(['id_costos' => $id_costos, 'id_empleat' => $id_empleat]);
                    //return response()->json($empleatCost);
                    $empleatCost->cost_empleat += $cost;
                    $empleatCost->save();
                }
                //-----------------------Costos Tecnic-------------------
                if ($registre->tecnic != null){
                    $cost = 0;

                    $id_costos = $vec->id_costos;
                    $id_empleat = $registre->director->id_empleat;
                    foreach ($registre->tecnic->carrec as $empleatCarrec){
                        if ($empleatCarrec->id_tarifa == 3){
                            $cost += $empleatCarrec->preu_carrec;
                        } else if ($empleatCarrec->id_tarifa == 4){
                            $cost += $empleatCarrec->preu_carrec;
                        }
                    }
                    $empleatCost = EmpleatCost::firstOrCreate(['id_costos' => $id_costos, 'id_empleat' => $id_empleat]);
                    //return response()->json($empleatCost);
                    $empleatCost->cost_empleat += $cost;
                    $empleatCost->save();
                }
            
                try {
                    $registre->save();
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }

                return redirect()->route('indexVec')->with('success', 'Valoració Econòmica creada correctament.');
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix aquest registre'));
            }
            
        }
    }
    
    public function delete(Request $request) {
        EmpleatCost::where('id_costos', $request["id"])->delete();
        $costos = Costos::where('id_costos', $request["id"])->first();
        //return response()->json($estadillo);
        $produccio = RegistreProduccio::find($costos->id_registre_produccio);
        $produccio->vec = false;
        $produccio->save();
        $costos->delete();
        
        return redirect()->back()->with('success', 'Valoració econòmica eliminada correctament.');
    }
}
