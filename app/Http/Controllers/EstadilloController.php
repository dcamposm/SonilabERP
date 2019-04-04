<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estadillo;
use App\RegistreProduccio;
use App\ActorEstadillo;
use App\EmpleatExtern;
use App\CarrecEmpleat;
use Excel;
use Validator;

class EstadilloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $estadillos = Estadillo::all()->sortBy("id_registre_produccio");
        //return response()->json($estadillos[1]->registreProduccio);
        //$registreProduccio = Projecte::all();
        $showEstadillos = array();
        
        foreach ($estadillos as $estadillo){
            //$projecte = RegistreProduccio::find($estadillo['id_registre_produccio']);
            //return response()->json($projecte);
            
            if ($estadillo->registreProduccio->subreferencia!=0){
                //return response()->json($estadillo);
                if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                        'titol'=>$estadillo->registreProduccio->titol,
                        'setmana' => $estadillo->registreProduccio->setmana,
                        'min'=>$estadillo->registreProduccio->subreferencia,
                        'max'=>$estadillo->registreProduccio->subreferencia,
                        'validat'=>$estadillo->registreProduccio->estadillo
                    );
                    //return response()->json($showEstadillos);
                } else {
                    if(!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana])){
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'titol'=>$estadillo->registreProduccio->titol,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'min'=>$estadillo->registreProduccio->subreferencia,
                            'max'=>$estadillo->registreProduccio->subreferencia,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                    } else {
                        //return response()->json($estadillo);
                        if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max']<$estadillo->registreProduccio->subreferencia){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max'] = $estadillo->registreProduccio->subreferencia;
                        } else if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min']>$estadillo->registreProduccio->subreferencia){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min'] = $estadillo->registreProduccio->subreferencia;
                        }
                        if ($estadillo->registreProduccio->estadillo == 0){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['validat'] = $estadillo->registreProduccio->estadillo;
                        }
                    }
                }
            } else {
                //return response()->json($estadillo);
                $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                    'id_estadillo'=>$estadillo->id_estadillo,
                    'setmana' => $estadillo->registreProduccio->setmana,
                    'titol'=>$estadillo->registreProduccio->titol,
                    'validat'=>$estadillo->registreProduccio->estadillo
                );
                //return response()->json($showEstadillos);
            }
        }
        //return response()->json($showEstadillos);

        //select crear estadillo
        $estadillos = Estadillo::all();
        $registreProduccio = RegistreProduccio::all();
        
        $arrayProjectes = array();
        $cont = 0;
        $exist = false;
        
        foreach ($registreProduccio as $projecte){
            foreach ($estadillos as $estadillo) {
                if ($projecte->id == $estadillo->id_registre_produccio){
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

        return View('estadillos.index', array('showEstadillos' => $showEstadillos, 'registreProduccio'=>$arrayProjectes));
    }
    
    public function show($id, $id_setmana = 0){
        $empleats = EmpleatExtern::all();
        if ($id_setmana == 0){
            $actors = ActorEstadillo::where('id_produccio', $id)->get(); 
            //return response()->json($actors);
            $estadillos = Estadillo::find($id);
            $estadillos->registreProduccio;
            //return response()->json($estadillos);
            //return response()->json($estadillos);//['registre_produccio']
            //$registreProduccio = Projecte::find($estadillos['id_registre_produccio']);
            //return response()->json($estadillos);
            return view('estadillos.showActor', array(
                'actors'    => $actors,
                'empleats'    => $empleats,
                'estadillos' => $estadillos
            ));
        } 
        
        $arrayActors = array();
        $registresProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->get();
        
        //return response()->json($registresProduccio);
        
        foreach ($registresProduccio as $registre) {
            $estadillo = Estadillo::where('id_registre_produccio', $registre['id'])->first();
            //return response()->json($estadillo);
            if ($estadillo){
                //return response()->json($estadillos);
                $actors = ActorEstadillo::where('id_produccio', $estadillo['id_estadillo'])->get();
                //return response()->json($actors);
                
                foreach ($actors as $actor) {  
                    if (!isset($arrayActors[$actor['id_actor']])){
                        $arrayActors[$actor['id_actor']] = array(
                            'id_actor' => $actor['id_actor'],
                            'cg_estadillo' =>  $actor['cg_estadillo'],
                            'take_estadillo' => $actor['take_estadillo']
                        );
                    } else {
                        $arrayActors[$actor['id_actor']]['cg_estadillo']+=($actor['cg_estadillo'] != null  ? $actor['cg_estadillo'] : 0);
                        $arrayActors[$actor['id_actor']]['take_estadillo']+=$actor['take_estadillo'];
                        //return response()->json($arrayActors);
                    }
                    //return response()->json($arrayActors);
                }  
                
                if (!isset($min)) {
                    $min = $registre['subreferencia'];
                    $max = $registre['subreferencia'];
                } else {
                    if ($registre['subreferencia'] < $min){
                        $min = $registre['subreferencia'];
                    } else if ($registre['subreferencia'] > $max) {
                        $max = $registre['subreferencia'];
                    }
                }
                $estadillos = Estadillo::where('id_registre_produccio', $registre['id'])->first()->registreProduccio;
            }
        }
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->first();
        
        return view('estadillos.showActor', array(
                'actors'    => $arrayActors,
                'empleats'    => $empleats,
                'estadillos' => $estadillos,
                'registreProduccio' => $registreProduccio,
                'min' => $min,
                'max' => $max
            ));
    }
    
    public function showSetmana($id, $id_setmana) {
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->get();
        //return response()->json($registreProduccio);
        
        foreach($registreProduccio as $registre){
            $registre->getEstadillo;
        }
        //return response()->json($registreProduccio);      
        
        return View('estadillos.show', array('registreProduccio'=>$registreProduccio));
    }
    
    public function import() 
    {
        if (request()->has('import_file')) {
            $titol = request()->file('import_file')->getClientOriginalName();
        } else {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha introduit un excel'));
        }
        
        $arrayTitol = explode('_', $titol);
        $idRegEntrada = $arrayTitol[0];
        $arrayRegProd = explode(' ', $arrayTitol[count($arrayTitol)-1]);
        $idRegProduccio = $arrayRegProd[0];
        //return response()->json(Projecte::where('id_registre_entrada', $idRegEntrada)->where('id', $idRegProduccio)->get());
        //CREACIO ESTADILLO
        $projecte = RegistreProduccio::where('id_registre_entrada', $idRegEntrada)
                ->where('subreferencia', $idRegProduccio)->first();
        $estadillo = Estadillo::where('id_registre_produccio', $projecte['id'])->first();
        if ($projecte){
            if ($estadillo){
               return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Aquest estadillo ja existeix'));
            } else {
                $estadillo = new Estadillo;
                $estadillo->id_registre_produccio = $projecte['id'];
                $estadillo->save();
                //return response()->json('Estadillo creado');
            }
        } else {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Comprova el numero de referencia del nom del fitxer'));
        }
        //CREACIO ACTORS ESTADILLO
        $excel = Excel::toArray(new Estadillo,request()->file('import_file'));
        $arrayEstadillo = $excel[1];
        //return response()->json($arrayEstadillo);
        /*$arrayActors = array();
        $cont = 0;*/
        
        for ($i = 3; $i < count($arrayEstadillo); $i++){
            $nomCognom = explode(' ', $arrayEstadillo[$i][0]);
            try {
                $empleat = EmpleatExtern::where('nom_empleat', $nomCognom[1])
                        ->where('cognom1_empleat', $nomCognom[0])->first();
            } catch (\Exception $ex) {
                $empleat = EmpleatExtern::where('nom_empleat', $nomCognom[0])->first();
            }
            
            
            if ($empleat){ 
                //return response()->json('Existeix');
                $actor = ActorEstadillo::where('id_produccio', $estadillo['id_estadillo'])
                        ->where('id_actor', $empleat['id_empleat'])->first();
                //return response()->json($actor);
                if ($actor){
                    $actor->id_produccio = $estadillo['id_estadillo'];
                    $actor->id_actor = $empleat['id_empleat'];
                    $actor->take_estadillo = $arrayEstadillo[$i][1];
                    $actor->save();
                } else {
                    $actor = new ActorEstadillo;
                    $actor->id_produccio = $estadillo['id_estadillo'];
                    $actor->id_actor = $empleat['id_empleat'];
                    $actor->take_estadillo = $arrayEstadillo[$i][1];
                    $actor->save();
                }
                
            } else {
                $alert = 'WARNING. No s\'ha pogut introduir tots els actors. '
                        . 'Comprova si existeixen en \'GESTIÓ DE PERSONAL\'.';
                //return response()->json('ERROR. No existeix '.$nomCognom[1].' '.$nomCognom[0]);
            }
            //$arrayActors[$cont]=$arrayEstadillo[$i];
            //$cont++;
            
        }
        
        if (isset($alert)){
            return redirect()->back()->with('alert', $alert);
        }
        return redirect()->back()->with('success', 'Estadillo importat correctament.');  
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
                $projecte = RegistreProduccio::find(request()->input('id_registre_produccio'));
                //return response()->json($projecte);
                $estadillo = new Estadillo;
                
                $estadillo->id_registre_produccio=request()->input('id_registre_produccio');
                $estadillo->save();
                
                try {
                    $estadillo->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }

                return redirect()->route('indexEstadillos')->with('success', 'Estadillo creat correctament.');
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix aquest registre'));
            }
            
        }
    }
    
    public function updateView($id) {
        $estadillosAll = Estadillo::all();
        $registreProduccio = RegistreProduccio::all();
        $estadillos = Estadillo::find($id);
        $arrayProjectes = array();
        $cont = 0;
 
        
        foreach ($registreProduccio as $projecte){
            $exist = false;
            foreach ($estadillosAll as $estadillo) {
                if ($projecte->id == $estadillo->id_registre_produccio 
                        && $projecte->id != $estadillos->id_registre_produccio){
                    $exist = true;
                }
            }
            if ($exist == false) {
                $arrayProjectes[$cont] = $projecte;
                $cont++;
            }
        }
        $registre = Estadillo::find($id)->registreProduccio;
        return view('estadillos.create', array('estadillos'=> $estadillos,
            'registreProduccio'=> $arrayProjectes, 'registre'=>$registre));
    }

    public function update($id) {
        $estadillo = Estadillo::find($id);
        if ($estadillo) {
            $v = Validator::make(request()->all(), [
                'id_registre_produccio'   => 'required',
            ]);
    
            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
            } else {
                $projecte = RegistreProduccio::find(request()->input('id_registre_produccio'));
                //return response()->json($projecte);
                $estadillo->id_registre_produccio=request()->input('id_registre_produccio');
                $estadillo->save();
                
                $projecte->estadillo = request()->input('validat');
                $projecte->save();
                
                try {
                    $estadillo->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el estadillo.'));
                }
    
                return redirect()->route('indexEstadillos')->with('success', 'Estadillo modificat correctament.');
            }
        }
    }
    
    
    public function insertActorView($id, $setmana=0){
        $carrecEmpleat = CarrecEmpleat::where('id_carrec', '1')->get();
        
        $cont = 0;
        $empleatsArray = array();
        foreach ($carrecEmpleat as $empleat){
            if (!isset($empleatsArray)){                    
                $empleatsArray[$cont] = $empleat->id_empleat;
                $cont++;
            } else {
                $rep = false;
                for ($i = 0; $i < $cont; $i++){
                    if ($empleatsArray[$i] == $empleat->id_empleat){
                        $rep = true;
                        $i = $cont;
                    }
                }

                if ($rep == false) {
                    $empleatsArray[$cont] = $empleat->id_empleat;
                    $cont++;
                }
            }
        }

        $empleats = Array();
        //Despres introdueix en una altre array, tots els atributs del empleat
        for ($i = 0; $i < count($empleatsArray); $i++){
            $empleats[$i] =  EmpleatExtern::where('id_empleat', $empleatsArray[$i])->first();
        } 
        
        if ($setmana == 0){
           $estadillos = Estadillo::find($id);
        
            return View('estadillos.createActor', array('empleats'=>$empleats, 'estadillos'=>$estadillos)); 
        } 
        
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        //return response()->json($registreProduccio);
        foreach ($registreProduccio as $projecte){
            $projecte->getEstadillo;
        }
        
        //$estadillos = Estadillo::all();        
        /*$arrayProjectes = array();
        $i = 0;
        
        foreach ($registreProduccio as $projecte){
            $exist = true;
            //return response()->json($projecte);
            foreach ($estadillos as $estadillo) {
                
                if ($projecte->id == $estadillo->id_registre_produccio){
                    $exist = false;
                }
            }
            if ($exist == false) {
                //return response()->json($projecte);
                $arrayProjectes[$i] = $projecte;
                $i++;
            }
        }*/
        
        //return response()->json($registreProduccio);
        return View('estadillos.createActor', array('empleats'=>$empleats, 'registreProduccio' => $registreProduccio));
        
    }

    public function insertActor($setmana = 0)
    {
        //return response()->json(request()->all());
        if ($setmana == 0){
           $v = Validator::make(request()->all(), [
                'id_actor'          => 'required',
                'take_estadillo'     => 'required',
                'cg_estadillo'          => 'required',
            ]);

            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
            } else {
                $actor = new ActorEstadillo(request()->all());               

                try {
                    $actor->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut afegir l\'actor.'));
                }

                return redirect()->back()->with('success', 'Actor afegit correctament.');
            } 
        }
        
        //return response()->json(request()->all());
        
        $v = Validator::make(request()->all(), [
            'id_actor'          => 'required'
        ]);
        
        if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
            } else {
                $estadillos= Estadillo::all();
                //return response()->json($estadillos);
                foreach ($estadillos as $estadillo){
                    //return response()->json($estadillo->id_registre_produccio);
                    if (request()->has('take_estadillo_'.$estadillo->id_registre_produccio)){
                        //return response()->json($estadillo->id_estadillo);
                        if (!ActorEstadillo::where('id_produccio',$estadillo->id_estadillo)->where('id_actor', request()->input('id_actor'))->first()){
                            //return response()->json($estadillo->id_registre_produccio);
                            $actor = new ActorEstadillo;
                            $actor->id_produccio=$estadillo->id_estadillo;
                            $actor->id_actor=request()->input('id_actor');
                            $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                            $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                            $actor->save();
                        }
                        //return response()->json($estadillo->id_registre_produccio);
                    }                    
                    //return response()->json('FALSE');
                }
                return redirect()->back()->with('success', 'Actor afegit correctament.');
            }
    }
    
    public function updateActorView($id, $id_actor, $setmana = 0) {
        $carrecEmpleat = CarrecEmpleat::where('id_carrec', '1')->get();
        
        $cont = 0;
        $empleatsArray = array();
        foreach ($carrecEmpleat as $empleat){
            if (!isset($empleatsArray)){                    
                $empleatsArray[$cont] = $empleat->id_empleat;
                $cont++;
            } else {
                $rep = false;
                for ($i = 0; $i < $cont; $i++){
                    if ($empleatsArray[$i] == $empleat->id_empleat){
                        $rep = true;
                        $i = $cont;
                    }
                }

                if ($rep == false) {
                    $empleatsArray[$cont] = $empleat->id_empleat;
                    $cont++;
                }
            }
        }

        $empleats = Array();
        //Despres introdueix en una altre array, tots els atributs del empleat
        for ($i = 0; $i < count($empleatsArray); $i++){
            $empleats[$i] =  EmpleatExtern::where('id_empleat', $empleatsArray[$i])->first();
        } 
        
        if ($setmana == 0){
            $estadillos = Estadillo::find($id);
            //return response()->json($estadillos);
            $actor = ActorEstadillo::where('id_produccio', $id)->where('id_actor', $id_actor)->first();
            
            //return response()->json($empleats);
            
            return View('estadillos.createActor', array('actor'=> $actor,'empleats'=>$empleats, 'estadillos'=>$estadillos)); 
        } 
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        //return response()->json($registreProduccio);
        $actor = array();
        
        foreach ($registreProduccio as $projecte){
            
            //return response()->json($projecte);
            if (!empty($projecte->getEstadillo->actors)){
                $projecte->getEstadillo->actors;
                array_push ($actor , ActorEstadillo::where('id_produccio', $projecte->getEstadillo->id_estadillo)
                                                                ->where('id_actor', $id_actor)
                                                                ->first());
            }
        }

        //return response()->json($actor);
        return view('estadillos.createActor', array('actor'=> $actor,'empleats'=> $empleats, 'registreProduccio'=> $registreProduccio));
    }

    public function updateActor($id, $id_actor, $setmana=0) {
        
        if ($setmana == 0) {
            $actor = ActorEstadillo::where('id_produccio',$id)->where('id_actor',$id_actor)->first();
            if ($actor) {
                $v = Validator::make(request()->all(), [
                    'id_actor'          => 'required',
                    'take_estadillo'     => 'required',
                    'cg_estadillo'          => 'required',
                ]);

                if ($v->fails()) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
                } else {
                    $actor->fill(request()->all());

                    try {
                        $actor->save(); 
                    } catch (\Exception $ex) {
                        return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar l\'actor.'));
                    }

                    return redirect()->back()->with('success', 'Actor modificat correctament.');
                }
            }  
        }
        
        //return response()->json($id_actor);
        
        $v = Validator::make(request()->all(), [
            'id_actor'          => 'required'
        ]);
        
        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            
            $estadillos= Estadillo::all();

            foreach ($estadillos as $estadillo){
                //return response()->json($estadillo->id_registre_produccio);
                if (request()->has('take_estadillo_'.$estadillo->id_registre_produccio)){
                    $actor = ActorEstadillo::where('id_produccio', $estadillo->id_estadillo)
                                ->where('id_actor', request()->input('id_actor'))->first();
                    //return response()->json($actor);
                    if (!$actor) {
                        $actor = new ActorEstadillo;
                        $actor->id_produccio=$estadillo->id_estadillo;
                        $actor->id_actor=request()->input('id_actor');
                        $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->save();
                    } else {
                        //return response()->json($actor);
                        $actor->id_produccio=$estadillo->id_estadillo;
                        $actor->id_actor=request()->input('id_actor');
                        $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->save(); 
                    }
                    //return response()->json($estadillo->id_registre_produccio);
                }                    
                //return response()->json('FALSE');
            }
            return redirect()->back()->with('success', 'Actor afegit correctament.');
        }
    }

    public function find()
    {
        //return response()->json(request()->all());
        if (request()->input("searchBy") == '1'){
            $estadillos = Estadillo::all()->sortBy("id_registre_produccio");
            //return response()->json($estadillos[1]->registreProduccio);
            //$registreProduccio = Projecte::all();
            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
                //$projecte = RegistreProduccio::find($estadillo['id_registre_produccio']);
                //return response()->json($projecte);
                if ($estadillo->registreProduccio->estadillo == request()->input("search_Validat")) {
                    if ($estadillo->registreProduccio->subreferencia!=0){
                        //return response()->json($estadillo);
                        if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                'titol'=>$estadillo->registreProduccio->titol,
                                'setmana' => $estadillo->registreProduccio->setmana,
                                'min'=>$estadillo->registreProduccio->subreferencia,
                                'max'=>$estadillo->registreProduccio->subreferencia,
                                'validat'=>$estadillo->registreProduccio->estadillo
                            );
                            //return response()->json($showEstadillos);
                        } else {
                            if(!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana])){
                                $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                    'titol'=>$estadillo->registreProduccio->titol,
                                    'setmana' => $estadillo->registreProduccio->setmana,
                                    'min'=>$estadillo->registreProduccio->subreferencia,
                                    'max'=>$estadillo->registreProduccio->subreferencia,
                                    'validat'=>$estadillo->registreProduccio->estadillo
                                );
                            } else {
                                //return response()->json($estadillo);
                                if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max']<$estadillo->registreProduccio->subreferencia){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max'] = $estadillo->registreProduccio->subreferencia;
                                } else if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min']>$estadillo->registreProduccio->subreferencia){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min'] = $estadillo->registreProduccio->subreferencia;
                                }
                                if ($estadillo->registreProduccio->estadillo == 0){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['validat'] = $estadillo->registreProduccio->estadillo;
                                }
                            }
                        }
                    } else {
                        //return response()->json($estadillo);
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'id_estadillo'=>$estadillo->id_estadillo,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'titol'=>$estadillo->registreProduccio->titol,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                        //return response()->json($showEstadillos);
                    }
                }
            }
            
        }  else {
            $estadillos = Estadillo::all()->sortBy("id_registre_produccio");
            //return response()->json($estadillos[1]->registreProduccio);
            //$registreProduccio = Projecte::all();
            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
                //$projecte = RegistreProduccio::find($estadillo['id_registre_produccio']);
                //return response()->json($projecte);
                if ($estadillo->registreProduccio->id_registre_entrada == request()->input("search_term") || preg_match('/'.request()->input("search_term").'/i' , $estadillo->registreProduccio->titol)) {
                    if ($estadillo->registreProduccio->subreferencia!=0){
                        //return response()->json($estadillo);
                        if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                'titol'=>$estadillo->registreProduccio->titol,
                                'setmana' => $estadillo->registreProduccio->setmana,
                                'min'=>$estadillo->registreProduccio->subreferencia,
                                'max'=>$estadillo->registreProduccio->subreferencia,
                                'validat'=>$estadillo->registreProduccio->estadillo
                            );
                            //return response()->json($showEstadillos);
                        } else {
                            if(!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana])){
                                $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                    'titol'=>$estadillo->registreProduccio->titol,
                                    'setmana' => $estadillo->registreProduccio->setmana,
                                    'min'=>$estadillo->registreProduccio->subreferencia,
                                    'max'=>$estadillo->registreProduccio->subreferencia,
                                    'validat'=>$estadillo->registreProduccio->estadillo
                                );
                            } else {
                                //return response()->json($estadillo);
                                if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max']<$estadillo->registreProduccio->subreferencia){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max'] = $estadillo->registreProduccio->subreferencia;
                                } else if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min']>$estadillo->registreProduccio->subreferencia){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min'] = $estadillo->registreProduccio->subreferencia;
                                }
                                if ($estadillo->registreProduccio->estadillo == 0){
                                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['validat'] = $estadillo->registreProduccio->estadillo;
                                }
                            }
                        }
                    } else {
                        //return response()->json($estadillo);
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'id_estadillo'=>$estadillo->id_estadillo,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'titol'=>$estadillo->registreProduccio->titol,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                        //return response()->json($showEstadillos);
                    }
                }
            }
        }
        
        return View('estadillos.index', array('showEstadillos' => $showEstadillos,
                                                'return' => 1));
    }
    
    public function findActor($id, $id_setmana = 0){
        $empleats = EmpleatExtern::whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"'
                                    . 'OR LOWER(cognom1_empleat) like "%'. strtolower(request()->input("search_term")).'%"'
                                    . 'OR LOWER(cognom2_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
        if ($id_setmana == 0){
            $actors = ActorEstadillo::where('id_produccio', $id)->get(); 
            //return response()->json($empleats);
            $estadillos = Estadillo::find($id);
            $estadillos->registreProduccio;
            //return response()->json($estadillos);
            //return response()->json($estadillos);//['registre_produccio']
            //$registreProduccio = Projecte::find($estadillos['id_registre_produccio']);
            //return response()->json($estadillos);
            return view('estadillos.showActor', array(
                'actors'    => $actors,
                'empleats'    => $empleats,
                'estadillos' => $estadillos
            ));
        } 
        
        $arrayActors = array();
        $registresProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->get();
        
        //return response()->json($registresProduccio);
        
        foreach ($registresProduccio as $registre) {
            $estadillo = Estadillo::where('id_registre_produccio', $registre['id'])->first();
            //return response()->json($estadillos);
            if ($estadillo){
                //return response()->json($estadillos);
                $actors = ActorEstadillo::where('id_produccio', $estadillo['id_estadillo'])->get();
                //return response()->json($actors);
                
                foreach ($actors as $actor) {  
                    if (!isset($arrayActors[$actor['id_actor']])){
                        $arrayActors[$actor['id_actor']] = array(
                            'id_actor' => $actor['id_actor'],
                            'cg_estadillo' =>  $actor['cg_estadillo'],
                            'take_estadillo' => $actor['take_estadillo']
                        );
                    } else {
                        $arrayActors[$actor['id_actor']]['cg_estadillo']+=$actor['cg_estadillo'];
                        $arrayActors[$actor['id_actor']]['take_estadillo']+=$actor['take_estadillo'];
                        //return response()->json($arrayActors);
                    }
                    //return response()->json($arrayActors);
                }  
                
                if (!isset($min)) {
                    $min = $registre['subreferencia'];
                    $max = $registre['subreferencia'];
                } else {
                    if ($registre['subreferencia'] < $min){
                        $min = $registre['subreferencia'];
                    } else if ($registre['subreferencia'] > $max) {
                        $max = $registre['subreferencia'];
                    }
                }
                $estadillos = Estadillo::where('id_registre_produccio', $registre['id'])->first()->registreProduccio;
            }
        }
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->first();
        
        return view('estadillos.showActor', array(
                'actors'    => $arrayActors,
                'empleats'    => $empleats,
                'estadillos' => $estadillos,
                'registreProduccio' => $registreProduccio,
                'min' => $min,
                'max' => $max
            ));
    }
    
    public function delete(Request $request)
    {
        ActorEstadillo::where('id_produccio', $request["id"])->delete();
        Estadillo::where('id_estadillo', $request["id"])->delete();
        return redirect()->back()->with('success', 'Estadillo eliminat correctament.');
    }
    
    public function deleteActor(Request $request)
    {
        ActorEstadillo::where('id', $request["id"])->delete();
        return redirect()->back()->with('success', 'Actor eliminat correctament.');
    }
}
