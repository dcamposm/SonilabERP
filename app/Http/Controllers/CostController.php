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
    
    public function index($ref = 0)
    {
        $vecs = Costos::with('registreProduccio.registreEntrada.client')->orderBy('id_registre_produccio')->get();       
        //return response()->json($vecs);
        $costos = array();
        
        if ($ref == 0){
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
                            'episodi'=>array($vec->registreProduccio->subreferencia),
                            'setmana'=>$vec->registreProduccio->setmana
                        );
                    } else {
                        array_push($costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]['episodi'],$vec->registreProduccio->subreferencia);
                    }
                }
            }
        } else {
            foreach ($vecs as $vec){
                if ($vec->registreProduccio->id_registre_entrada == $ref){
                    //return response()->json($vec);
                    if (!isset($costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega])){
                        $costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]= array(
                            'titol'=>$vec->registreProduccio->titol,
                            'client'=>$vec->registreProduccio->registreEntrada->client->nom_client,
                            'episodi'=>array($vec->registreProduccio->subreferencia),
                            'setmana'=>$vec->registreProduccio->setmana
                        );
                    } else {
                        array_push($costos[$vec->registreProduccio->id_registre_entrada][$vec->registreProduccio->data_entrega]['episodi'],$vec->registreProduccio->subreferencia);
                    }
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
            //return response()->json($vec->empleats);
            $empleatsInfo = array();
            foreach ($vec->empleats as $empleat){
                if ($empleat->tarifa->carrec->nom_carrec == 'Actor'){
                    if ($empleat->tarifa->nombre_corto != 'canso'){
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
                        $empleatsInfo['Canço'][$empleat->empleat->id_empleat] = array(
                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                            'tasca' => array('canço'),
                            'total' => $empleat->cost_empleat
                        );
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
            $vecs = Costos::with('registreProduccio.registreEntrada.client')->with('empleats.empleat.carrec.carrec')->orderBy('id_registre_produccio')->get();
            
            $total = 0;
            $totalSS = 0;
            $maxDocu = array();
            //return response()->json($vecs);

            $empleatsInfo = array();
            foreach ($vecs as $vec) {
                //return response()->json($vecs);
                if ($vec->registreProduccio->vec == 1){
                    //return response()->json($id);
                    if ($vec->registreProduccio->id_registre_entrada == $id && date('d-m-Y', strtotime($vec->registreProduccio->data_entrega)) == $data){
                        //return response()->json($vec);
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
                            //return response()->json($vec->empleats);
                            //----------------------INFO ACTORS----------------------
                            if ($empleat->tarifa->carrec->nom_carrec == 'Actor'){
                                //------------Show la tarifa que no sigui ni canço ni documental--------------
                                if ($empleat->tarifa->nombre_corto != 'canso' && $empleat->tarifa->nombre_corto != 'docu'){
                                    if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                                            'tk' => 0,
                                            'cg' => 0,
                                            'total' => $empleat->cost_empleat
                                        );
                                        //return response()->json($empleatsInfo);
                                        foreach ($empleat->empleat->estadillo as $actor){
                                            //return response()->json($vec->registreProduccio->getEstadillo->id_estadillo);
                                            if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){
                                                //return response()->json($empleat->id_tarifa);
                                                if ($empleat->id_tarifa == 5 || $empleat->id_tarifa == 7){
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                                                } else if ($empleat->id_tarifa == 6 || $empleat->id_tarifa == 8){
                                                   $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo; 
                                                }
                                                //return response()->json($empleatsInfo);
                                            }
                                            //return response()->json($vec->registreProduccio->getEstadillo->id_estadillo);
                                        }

                                        $total += $empleat->cost_empleat;
                                        $totalSS += $empleat->cost_empleat;

                                        //return response()->json($empleatsInfo);
                                    } else {
                                        //return response()->json($vec->empleats);
                                        $total += $empleat->cost_empleat;
                                        $totalSS += $empleat->cost_empleat;
                                        foreach ($empleat->empleat->estadillo as $actor){
                                            //return response()->json($vec->registreProduccio->getEstadillo);
                                            if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){
                                                if ($empleat->id_tarifa == 5 || $empleat->id_tarifa == 7){
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                                                } else if ($empleat->id_tarifa == 6 || $empleat->id_tarifa == 8){
                                                   $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo; 
                                                }
                                            }
                                        }

                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;

                                        //return response()->json($empleat);
                                    } 
                                //---------------Show tarifa canço-----------
                                } else if ($empleat->tarifa->nombre_corto == 'canso'){
                                    if (!isset($empleatsInfo['Canço'][$empleat->empleat->id_empleat])) {
                                        $empleatsInfo['Canço'][$empleat->empleat->id_empleat] = array(
                                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                                            'tasca' => array('Canço'  => array('cost'=>$empleat->cost_empleat,'episodis' => array($vec->registreProduccio->subreferencia))),
                                            'total' => $empleat->cost_empleat
                                        );
                                        $total += $empleat->cost_empleat;
                                    } else {
                                        $total += $empleat->cost_empleat;
                                        
                                        $empleatsInfo['Canço'][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                                    }
                                //------------Show tarifa documental------------
                                } else if ($empleat->tarifa->nombre_corto == 'docu'){
                                    //return response()->json($empleat->empleat->carrec);;
                                    foreach ($empleat->empleat->carrec as $carrec) {
                                        if ($carrec->id_tarifa == 10){
                                            $maxDocu[$empleat->empleat->id_empleat]['docu'] = $carrec->preu_carrec;
                                        }
                                    }
                                    //return response()->json($maxDocu);
                                    if (!isset($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat])) {
                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat] = array(
                                            'nom' => ($empleat->empleat->nom_empleat.' '.$empleat->empleat->cognom1_empleat),
                                            'tk' => 0,
                                            'cg' => 0,
                                            'total' => $empleat->cost_empleat
                                        );
                                        //return response()->json($empleatsInfo);
                                        foreach ($empleat->empleat->estadillo as $actor){
                                            //return response()->json($vec->registreProduccio->getEstadillo->id_estadillo);
                                            if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){
                                                //return response()->json($empleat->id_tarifa);
                                                if ($empleat->id_tarifa == 10){
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo; 
                                                }
                                            }
                                        }

                                        //$total += $empleat->cost_empleat;
                                        //$totalSS += $empleat->cost_empleat;

                                        //return response()->json($empleatsInfo);
                                    } else {
                                        foreach ($empleat->empleat->estadillo as $actor){
                                            //return response()->json($vec->registreProduccio->getEstadillo->id_estadillo);
                                            if ($actor->id_produccio == $vec->registreProduccio->getEstadillo->id_estadillo){
                                                //return response()->json($empleat->id_tarifa);
                                                if ($empleat->id_tarifa == 10){
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['tk'] += $actor->take_estadillo;
                                                    $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['cg'] += $actor->cg_estadillo; 
                                                }
                                            }
                                        } 
                                        
                                        $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] += $empleat->cost_empleat;
                                        
                                        if ($empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] > $maxDocu[$empleat->empleat->id_empleat]['docu']){
                                            $empleatsInfo[$empleat->tarifa->carrec->nom_carrec][$empleat->empleat->id_empleat]['total'] = $maxDocu[$empleat->empleat->id_empleat]['docu'];
                                        }
                                    }
                                }
                            }
                                
                            //-------------INFO COL·LABORADORS--------------
                            else {
                                //return response()->json($vec);
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
            }
            //return response()->json($maxDocu);
            if (empty($maxDocu)){
                $totalSS = ($totalSS/100)*32.35;
                $total += $totalSS;
            } else {
                foreach ($empleatsInfo['Actor'] as $actor){
                    $totalSS += $actor['total'];
                    $total += $actor['total'];
                }
                
                $totalSS = ($totalSS/100)*32.35;
                $total += $totalSS;
                //return response()->json($empleatsInfo);
            }
            //return response()->json($empleatsInfo);
            return View('vec.show', array('vec' => $vecInfo, 'empleatsInfo' => $empleatsInfo, 'total' => $total, 'totalSS' => $totalSS));
        }
    }
    
    public function generar($id)
    {
        $registre = RegistreProduccio::with('getEstadillo.actors.empleat.carrec.tarifa')->with('traductor.carrec')
                ->with('ajustador')->with('linguista')->with('director')->with('tecnic')
                ->with('registreEntrada')->find($id);
        //return response()->json($registre->getEstadillo->actors);
        $vec = Costos::where('id_registre_produccio', $id)->first();
        if (!$vec){
            if ($registre->getEstadillo != null){
                $vec = new Costos();
                $vec->id_registre_produccio = $id;
                $vec->save();
                $total = 0;
            //------------------------Costos Actors---------------------------------
                if (!empty($registre->getEstadillo->actors)){
                    $totalSS = 0;
                    foreach ($registre->getEstadillo->actors as $actor){
                        //return response()->json($actor->empleat->carrec);
                        //$cost = 0;
                        //$empleatCost->cost_empleat = ;
                        if ($registre->registreEntrada->id_servei == 1){
                        //----------------Media Documental----------------
                            if ($registre->registreEntrada->id_media == 1) {
                                $empleatCost = new EmpleatCost();
                                $empleatCost->id_costos = $vec->id_costos;
                                $empleatCost->id_empleat = $actor->id_actor;
                                $empleatCost->id_tarifa = 10;
                                $costTotal = 0;
                                $docu = 0;
                                foreach ($actor->empleat->carrec as $actorCarrec){
                                    if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && $actorCarrec->preu_carrec != 0){
                                        if ($actorCarrec->tarifa->nombre_corto == 'video_take') {
                                            $costTotal += $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'video_cg') {
                                            $costTotal += $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'docu') {
                                            $docu = $actorCarrec->preu_carrec;
                                        }
                                    }
                                }
                                if ($costTotal > $docu){
                                    $costTotal = $docu;
                                }
                                $empleatCost->cost_empleat = $costTotal;
                                $empleatCost->save();
                                $total += $costTotal;
                                $totalSS += $costTotal;
                        //--------------Altres Medies-------------------
                            } else {
                                foreach ($actor->empleat->carrec as $actorCarrec){
                                    $empleatCost = new EmpleatCost();
                                    $empleatCost->id_costos = $vec->id_costos;
                                    $empleatCost->id_empleat = $actor->id_actor;
                                    if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && $actorCarrec->preu_carrec != 0){
                                        if ($actorCarrec->tarifa->nombre_corto == 'video_take') {
                                            $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->take_estadillo;
                                            $total += $empleatCost->cost_empleat;
                                            $totalSS += $empleatCost->cost_empleat;
                                            $empleatCost->id_tarifa = 5;
                                            $empleatCost->save();
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'video_cg') {
                                            $empleatCost->cost_empleat = $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                            $total += $empleatCost->cost_empleat;
                                            $totalSS += $empleatCost->cost_empleat;
                                            $empleatCost->id_tarifa = 6;
                                            $empleatCost->save();
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'canso') {
                                            $empleatCost->cost_empleat = $actorCarrec->preu_carrec;
                                            $total += $empleatCost->cost_empleat;
                                            //$totalSS += $empleatCost->cost_empleat;
                                            $empleatCost->id_tarifa = 9;
                                            $empleatCost->save();
                                        }
                                    }
                                }
                            }                           
                        } else {
                        //----------------Media Documental----------------
                            if ($registre->registreEntrada->media->nom_media == 1) {
                                $empleatCost = new EmpleatCost();
                                $empleatCost->id_costos = $vec->id_costos;
                                $empleatCost->id_empleat = $actor->id_actor;
                                $empleatCost->id_tarifa = 10;
                                $costTotal = 0;
                                $docu = 0;
                                foreach ($actor->empleat->carrec as $actorCarrec){
                                    if ($registre->registreEntrada->id_idioma == $actorCarrec->id_idioma && $actorCarrec->preu_carrec != 0){
                                        if ($actorCarrec->tarifa->nombre_corto == 'video_take') {
                                            $costTotal += $actorCarrec->preu_carrec * $actor->take_estadillo;
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'video_cg') {
                                            $costTotal += $actorCarrec->preu_carrec * $actor->cg_estadillo;
                                        } else if ($actorCarrec->tarifa->nombre_corto == 'docu') {
                                            $docu = $actorCarrec->preu_carrec;
                                        }
                                    }
                                }
                                if ($costTotal > $docu){
                                    $costTotal = $docu;
                                }
                                $empleatCost->cost_empleat = $costTotal;
                                $empleatCost->save();
                                $total += $costTotal;
                                $totalSS += $costTotal;
                        //--------------Altres Medies-------------------
                            } else {
                                //return response()->json($actor);
                                foreach ($actor->empleat->carrec as $actorCarrec){
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
                    }
                    $total += ($totalSS/100)*32.35;
                }
                //return response()->json($registre->getEstadillo->actors);
                //-----------------------Costos Traductor-------------------
                if ($registre->traductor != null){
                    $empleatCost = new EmpleatCost();
                    $empleatCost->id_costos = $vec->id_costos;
                    $empleatCost->id_empleat = $registre->traductor->id_empleat;

                    foreach ($registre->traductor->carrec as $empleatCarrec){
                        if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'traductor' && $empleatCarrec->preu_carrec != 0){
                            $empleatCost->cost_empleat = $empleatCarrec->preu_carrec * ($registre->registreEntrada->minuts / $registre->registreEntrada->total_episodis);
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
                            $empleatCost->cost_empleat = $empleatCarrec->preu_carrec * ($registre->registreEntrada->minuts / $registre->registreEntrada->total_episodis);
                            $total += $empleatCost->cost_empleat;
                            $empleatCost->id_tarifa = 13;
                            $empleatCost->save();
                        }
                    }
                }
                //-----------------------Costos Linguista-------------------
                if ($registre->linguista != null){
                    $empleatCost = new EmpleatCost();
                    $empleatCost->id_costos = $vec->id_costos;
                    $empleatCost->id_empleat = $registre->linguista->id_empleat;
                    foreach ($registre->linguista->carrec as $empleatCarrec){
                        if ($registre->registreEntrada->id_idioma == $empleatCarrec->id_idioma && $empleatCarrec->tarifa->nombre_corto == 'linguista' && $empleatCarrec->preu_carrec != 0){
                            $empleatCost->cost_empleat = $empleatCarrec->preu_carrec * ($registre->registreEntrada->minuts / $registre->registreEntrada->total_episodis);
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
                            $empleatCost->cost_empleat = $empleatCarrec->preu_carrec * (($registre->registreEntrada->minuts / $registre->registreEntrada->total_episodis)/10);;
                            $total += $empleatCost->cost_empleat;
                            $empleatCost->id_tarifa = 1;
                            $empleatCost->save();
                        } else if ($empleatCarrec->tarifa->nombre_corto == 'minut' && $empleatCarrec->preu_carrec != 0 ){
                            $empleatCost->cost_empleat = $empleatCarrec->preu_carrec * ($registre->registreEntrada->minuts / $registre->registreEntrada->total_episodis);
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
                //return response()->json(Route::currentRouteName());
                if (Route::currentRouteName() == "vecActualitzar") {
                    return redirect()->back()->with('success', 'S\'ha actualitzat la valoració correctament');
                } else if (Route::currentRouteName() == "vecInsert"){
                    return redirect()->back()->with('success', 'S\'ha creat la valoració correctament');
                } else {
                    return redirect()->route('indexRegistreProduccio')->with('success', 'S\'ha creat la valoració correctament');
                }
            }
        }
         
        if (Route::currentRouteName() == "vecActualitzar") {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut actualitzar la valoració.'));
        } else if (Route::currentRouteName() == "vecInsert"){
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear la valoració, és té que crear el estadillo abans.'));
        } else if (Route::currentRouteName() == "vecGenerarSetmana"){
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear la valoració, és té que crear els estadillos abans.'));
        } else {
            return redirect()->route('indexRegistreProduccio')->withErrors(array('error' => 'ERROR. No s\'ha pogut crear la valoració, de la subreferencia '.$registre->subreferencia.', és té que crear el estadillo abans.'));
        }
        //return response()->json($registre); 
        //Poner mensaje error no esta el estadillo creado
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
            return CostController::generar(request()->input('id_registre_produccio'));  
        }
    }
    
    public function actualitzar($id, $setmana = 0)
    {
        if ($setmana == 0){
            EmpleatCost::where('id_costos', $id)->delete();
            $costos = Costos::where('id_costos', $id)->first();
            //return response()->json($costos);
            $id_registre = $costos->id_registre_produccio;
            //return response()->json($estadillo);
            $costos->delete();
            //return response()->json($costos);
            return CostController::generar($id_registre);  
        } else {
            $registres = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
            
            foreach ($registres as $registre) {
                $costos = Costos::where('id_registre_produccio', $registre->id)->first();
                EmpleatCost::where('id_costos', $costos->id_costos)->delete();
                $costos->delete();
            }
            //return response()->json($registres);
            return CostController::generarSetmana($id, $setmana); 
        }
        
    }
    
    public function generarSetmana($id, $setmana)
    {
        $registres = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        $estadillos = RegistreProduccio::where('estadillo', 1)->where('setmana', $setmana)->where('id_registre_entrada', $id)->get();
        //return response()->json($estadillos->count());
        if ($registres->count() != $estadillos->count()){
            return redirect()->route('indexRegistreProduccio')->withErrors(array('error' => 'ERROR. No s\'ha pogut crear la valoració, és té que crear els estadillos i validar-los abans.'));
        } else {
            foreach ($registres as $registre) {
                CostController::generar($registre->id);
            }
            if (Route::currentRouteName() == "vecActualitzar") {
                return redirect()->back()->with('success', 'S\'ha actualitzat la valoració correctament');
            } else {
                return redirect()->route('indexRegistreProduccio')->with('success', 'S\'han creat les valoracións correctament');
            }
        }
    }
    
    public function delete(Request $request) {
        //return response()->json($request->all());
        if (!$request->input('setmana')){
            EmpleatCost::where('id_costos', $request["id"])->delete();
            $costos = Costos::where('id_costos', $request["id"])->first();
            //return response()->json($estadillo);
            $produccio = RegistreProduccio::find($costos->id_registre_produccio);
            $produccio->vec = false;
            $produccio->save();
            $costos->delete();
        } else {
            $registres = RegistreProduccio::where('id_registre_entrada', $request->input('id'))->where('setmana', $request->input('setmana'))->get();
            
            foreach ($registres as $registre) {
                $costos = Costos::where('id_registre_produccio', $registre->id)->first();
                //return response()->json($costos);
                if ($costos){
                   EmpleatCost::where('id_costos', $costos->id_costos)->delete(); 
                   $costos->delete();
                }
                
                $registre->vec = false;
                $registre->save();
            }
        }
        
        return redirect()->back()->with('success', 'Valoració econòmica eliminada correctament.');
    }
}
