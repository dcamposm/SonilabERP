<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Costos;
use App\RegistreProduccio;
use App\EmpleatCost;
use Validator;
use Illuminate\Support\Facades\Route; 
class CostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $vecs = Costos::with('registreProduccio.registreEntrada.client')->orderBy('id_registre_produccio')->get();
        //return response()->json($vecs);
        $costos = array();
        
        foreach ($vecs as $vec){
            if ($vec->registreProduccio->subreferencia == 0){
                $costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]= array(
                    'id_costos'=>$vec->id_costos,
                    'titol'=>$vec->registreProduccio->titol,
                    'client'=>$vec->registreProduccio->registreEntrada->client->nom_client
                );
            } else {
                if (!isset($costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega])){
                    $costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]= array(
                        'titol'=>$vec->registreProduccio->titol,
                        'client'=>$vec->registreProduccio->registreEntrada->client->nom_client,
                        'episodi'=>array($vec->registreProduccio->subreferencia)
                    );
                } else {
                    array_push($costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]['episodi'],$vec->registreProduccio->subreferencia);
                }
            }
        }
        //return response()->json($costos);
        $registreProduccio = RegistreProduccio::all();
        
        $arrayProjectes = array();
        $cont = 0;
        $exist = false;
        
        foreach ($registreProduccio as $projecte){
            foreach ($vecs as $vec) {
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
    
    public function showPack($id, $data = 0)
    {
        $vecs = Costos::with('registreProduccio.registreEntrada.client')->orderBy('id_registre_produccio')->get();
        //return response()->json($vecs);
        $costos = array();
        foreach ($vecs as $vec){
            if ($vec->registreProduccio->id_registre_entrada == $id  && date('d-m-Y', strtotime($vec->registreProduccio->data_entrega)) == $data){
                $costos[$vec->id_costos]= array(
                    'referencia'=>$vec->registreProduccio->id_registre_entrada,
                    'entrega'=>$vec->registreProduccio->data_entrega,
                    'titol'=>$vec->registreProduccio->titol,
                    'client'=>$vec->registreProduccio->registreEntrada->client->nom_client,
                    'episodi'=>$vec->registreProduccio->subreferencia
                );
            }
        }
        //return response()->json($costos);
        return View('vec.showPack', array('costos' => $costos));
    }
    
    public function show($id, $data=0)
    {
        if ($data==0){
            $vec = Costos::with('registreProduccio.registreEntrada.client')->with('empleats.tarifa')->find($id);
            
            $totalSS = 0;
            //return response()->json($vec);
            $empleatsInfo = array();
            foreach ($vec->empleats as $empleat){
                if ($empleat->tarifa->carrec->nom_carrec == 'Actor'){
                    $totalSS += $empleat->cost_empleat;
                    if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                            'tk' => 0,
                            'cg' => 0,
                            'total' => $empleat->cost_empleat
                        );
                        
                        //$total += $empleat->cost_empleat;
                        //return response()->json($empleatsInfo);
                        foreach ($empleat->empleat->estadillo as $actor){
                            if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){

                                $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                                $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo;
                                //return response()->json($empleatsInfo);
                            }
                        }
                    } else {
                        //$total += $empleat->cost_empleat;
                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                    } 
                } else {
                    if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                            'tasca' => array(),
                            'total' => $empleat->cost_empleat
                        );
                        //$total += $empleat->cost_empleat;
                        if ($empleat->tarifa->carrec->nom_carrec == 'Traductor') array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->nombre_corto);
                        else array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->carrec->nom_carrec);
                    } else {
                        //$total += $empleat->cost_empleat;
                        //return response()->json($empleat->tarifa->nombre_corto);
                        if ($empleat->tarifa->carrec->nom_carrec == 'Traductor') array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'], $empleat->tarifa->nombre_corto);
                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                    } 
                }
            }
            //return response()->json($empleatsInfo);
            $totalSS = ($totalSS/100)*32.35;
            $total = $vec->cost_total;
            return View('vec.show', array('vec' => $vec, 'empleatsInfo' => $empleatsInfo, 'total' => $total, 'totalSS' => $totalSS, 'return' => 1));
        } else {
            $vecs = Costos::with('registreProduccio.registreEntrada.client')->with('empleats.tarifa')->orderBy('id_registre_produccio')->get();
            
            $total = 0;
            $totalSS = 0;
            //return response()->json($vecs);

            $empleatsInfo = array();
            foreach ($vecs as $vec) {
                if ($vec->registreProduccio->id_registre_entrada == $id && date('d-m-Y', strtotime($vec->registreProduccio->data_entrega)) == $data){
                    if (!isset($vecInfo)) {
                        $vecInfo = array(
                            'ref' => $id,
                            'titol' => $vec->registreProduccio->registreEntrada->titol,
                            'client' => $vec->registreProduccio->registreEntrada->client->nom_client,
                            'entrega' => $data,
                            'episodis' => array($vec->registreProduccio->subreferencia)
                        );
                    } else {
                        array_push($vecInfo['episodis'],$vec->registreProduccio->subreferencia);
                    }
                    foreach ($vec->empleats as $empleat){
                        //-------------INFO ACTORS--------------
                        if ($empleat->tarifa->carrec->nom_carrec == 'Actor'){
                            $totalSS += $empleat->cost_empleat;
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
                        } 
                        //-------------INFO COL·LABORADORS--------------
                        else {
                            if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                                $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                                    'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                                    'tasca' => array(($empleat->tarifa->carrec->nom_carrec == 'Traductor' ? $empleat->tarifa->nombre_corto : $empleat->tarifa->carrec->nom_carrec) =>array('cost'=>$empleat->cost_empleat,'episodis' => array($vec->registreProduccio->subreferencia))),
                                    'total' => $empleat->cost_empleat
                                );
                               $total += $empleat->cost_empleat;
                                //return response()->json($empleatsInfo);
                            } else {
                                $total += $empleat->cost_empleat;
                                
                                if ($empleat->tarifa->carrec->nom_carrec == 'Traductor'){
                                    if (isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'][$empleat->tarifa->nombre_corto])){
                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'][$empleat->tarifa->nombre_corto]['cost']+=$empleat->cost_empleat;
                                        array_push($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'][$empleat->tarifa->nombre_corto]['episodis'], $vec->registreProduccio->subreferencia);
                                    } else {
                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tasca'][$empleat->tarifa->nombre_corto] = array('cost'=>$empleat->cost_empleat,'episodis' => array($vec->registreProduccio->subreferencia));
                                        
                                    }
                                }
                                
                                $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                            } 
                        }
                    }
                }
            }
            $totalSS = ($totalSS/100)*32.35;
            //return response()->json($vecInfo);
            return View('vec.show', array('vec' => $vecInfo, 'empleatsInfo' => $empleatsInfo, 'total' => $total, 'totalSS' => $totalSS));
        }
        
    }
    
    public function generar($id)
    {
        $registre = RegistreProduccio::with('getEstadillo.actors.empleat.carrec.tarifa')->with('traductor.carrec')
                ->with('ajustador')->with('linguista')->with('director')->with('tecnic')
                ->with('registreEntrada')->find($id);
        //return response()->json($registre);
        $vec = Costos::where('id_registre_produccio', $id)->first();
        if (!$vec){
            $vec = new Costos();
            $vec->id_registre_produccio = $id;
            $vec->save();
            $total = 0;
            //----------------------Costos Actors---------------------------------
            if ($registre->getEstadillo != null){
                if (!empty($registre->getEstadillo->actors)){
                    $totalSS = 0;
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
                                        $total += $empleatCost->cost_empleat;
                                        $totalSS += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 5;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $total += $empleatCost->cost_empleat;
                                        $totalSS += $empleatCost->cost_empleat;
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
                                        $total += $empleatCost->cost_empleat;
                                        $totalSS += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 7;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $total += $empleatCost->cost_empleat;
                                        $totalSS += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 8;
                                        $empleatCost->save();
                                    }
                                }
                            }
                        }
                    }
                    $total += ($totalSS/100)*32.35;
                }
            }
            //return response()->json($registre->getEstadillo->actors);
            //-----------------------Costos Traductor-------------------
            if ($registre->traductor != null){
                $empleatCost = new EmpleatCost();
                $empleatCost->id_costos = $vec->id_costos;
                $empleatCost->id_empleat = $registre->traductor->id_empleat;
                
                foreach ($registre->traductor->carrec as $empleatCarrec){
                    if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'traductor' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 1;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'minut' && $empleatCarrec->preu_carrec != 0 ){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 3;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'mix' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 4;
                        $empleatCost->save();
                    }
                }

                
            }
            
            $registre->vec = 1;
            $registre->save();
            
            $vecF = Costos::find($vec->id_costos);
            $vecF->cost_total = $total;
            $vecF->save();
        }
        
        //return response()->json($registre);
        return redirect()->route('indexRegistreProduccio');
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
                $total = 0;
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
                            $total += $cost;
                            $total += ($cost/100)*32.35;
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
                    $total += $cost;
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
                    $total += $cost;
                    $empleatCost->save();
                }
                //-----------------------Costos Linguista-------------------
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
                    $total += $cost;
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
                    $total += $cost;
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
                    $total += $cost;
                    $empleatCost->save();
                }
            
                try {
                    $registre->save();
                    
                    $vecF = Costos::find($vec->id_costos);
                    $vecF->cost_total = $total;
                    $vecF->save();
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }

                return redirect()->route('indexVec')->with('success', 'Valoració Econòmica creada correctament.');
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix aquest registre'));
            }
            
        }
    }
    
    public function actualitzar($id)
    {
        EmpleatCost::where('id_costos', $id)->delete();
        $costos = Costos::where('id_costos', $id)->first();
        //return response()->json($costos);
        $id_registre = $costos->id_registre_produccio;
        //return response()->json($estadillo);
        $costos->delete();
        //return response()->json($costos);
        $registre = RegistreProduccio::with('getEstadillo.actors.empleat.carrec')->with('traductor.carrec')
                ->with('ajustador')->with('linguista')->with('director')->with('tecnic')
                ->with('registreEntrada')->find($id_registre);
        //return response()->json($registre->getEstadillo->actors);
        $vec = Costos::where('id_registre_produccio', $id_registre)->first();
        if (!$vec){
            $vec = new Costos();
            $vec->id_registre_produccio = $id_registre;
            $vec->save();
            $total = 0;
            //----------------------Costos Actors---------------------------------
            if ($registre->getEstadillo != null){
                if (!empty($registre->getEstadillo->actors)){
                    $totalActors = 0;
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
                                        $total += $empleatCost->cost_empleat;
                                        $totalActors += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 5;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $total += $empleatCost->cost_empleat;
                                        $totalActors += $empleatCost->cost_empleat;
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
                                        $total += $empleatCost->cost_empleat;
                                        $totalActors += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 7;
                                        $empleatCost->save();
                                    } else {
                                        $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        $total += $empleatCost->cost_empleat;
                                        $totalActors += $empleatCost->cost_empleat;
                                        $empleatCost->id_tarifa = 8;
                                        $empleatCost->save();
                                    }
                                }
                            }
                        }
                    }
                    $total += ($totalActors/100)*32.35;
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
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 1;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'minut' && $empleatCarrec->preu_carrec != 0 ){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $total += $empleatCost->cost_empleat;
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
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 3;
                        $empleatCost->save();
                    } else if ($empleatCarrec->tarifa->nombre_corto == 'mix' && $empleatCarrec->preu_carrec != 0){
                        $empleatCost->cost_empleat = $empleatCarrec->preu_carrec;
                        $total += $empleatCost->cost_empleat;
                        $empleatCost->id_tarifa = 4;
                        $empleatCost->save();
                    }
                }

                
            }
            
            $registre->vec = 1;
            $registre->save();
            
            $vecF = Costos::find($vec->id_costos);
            $vecF->cost_total = $total;
            $vecF->save();
        }
        
        //return response()->json($registre);
        return redirect()->back()->with('success', 'S\'ha actualitzat la valoració econòmica correctament.');
    }
    
    public function delete(Request $request) {
        //return response()->json(Route::currentRouteName());
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
