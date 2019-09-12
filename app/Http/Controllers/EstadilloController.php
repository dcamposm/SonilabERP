<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Estadillo,RegistreProduccio,ActorEstadillo,EmpleatExtern,CarrecEmpleat,Calendar};
use Excel;
use Validator;
use App\Http\Responsables\Estadillo\{EstadilloIndex,EstadilloShowActor,EstadilloShowActorSetmana};
use App\Imports\ActorEstadilloImport;
use DB;

class EstadilloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() //Funcio que crea la pagina de index 
    {
        //Agafa tots els estadillos i els ordena per registre de producció
        $estadillos = Estadillo::all()->sortBy("id_registre_produccio"); 
        
        return new EstadilloIndex($estadillos);
    }
    
    public function show($id, $id_setmana = 0){ //Funcio que mostra l'informació s'un estadillo
        $empleats = EmpleatExtern::all();
        if ($id_setmana == 0){
            $actors = ActorEstadillo::where('id_produccio', $id)->get(); //Busca tots els actors que participin amb l'estadillo
           
            $estadillos = Estadillo::find($id); //Busca l'estadillo
            $estadillos->registreProduccio;
            
            return new EstadilloShowActor($actors, $estadillos, $empleats);
        } 
        
        try {
            return new EstadilloShowActorSetmana($id, $id_setmana, $empleats);
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No hi han estadillos creats en la refernecia '.$id.' de la setmana '.$id_setmana));
        }   
    }
    
    public function showSetmana($id, $id_setmana) { //Funcio que mostra els etadillos per una setmana
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->get();
        
        foreach($registreProduccio as $registre){
            $registre->getEstadillo;
        }      
        
        return View('estadillos.show', array('registreProduccio'=>$registreProduccio));
    }
    
    public function import() 
    {
        //COMPROVACIÓ SI L'IMPORT SE ESTA FENT DESDE LA VISTA INDEX D'ESTADILLO 
        //O DESDE LA VISTA INDEX DE REGISTRE DE PRODUCCIÓ
        if (!request()->input('id_estadillo')){
            if (request()->has('import_file')) {
                $titol = request()->file('import_file')->getClientOriginalName();
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha introduit un excel'));
            }

            $arrayTitol = explode('_', $titol);
            $idRegEntrada = $arrayTitol[0];
            $idRegProduccio = $arrayTitol[1];

            $projecte = RegistreProduccio::where('id_registre_entrada', $idRegEntrada)->where('subreferencia', $idRegProduccio)->first();
        } else {
            if (request()->has('import_file')) {
                $titol = request()->file('import_file')->getClientOriginalName();
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha introduit un excel'));
            }
            $projecte = RegistreProduccio::where('id', request()->input('id_estadillo'))->first();
        }

        $estadillo = Estadillo::where('id_registre_produccio', $projecte['id'])->first();
        
        //CREACIÓ ESTADILLO
        if ($projecte){
            if (!$estadillo){
                $projecte->estadillo = true;
                $projecte->save();
                $estadillo = new Estadillo;
                $estadillo->id_registre_produccio = $projecte['id'];
                $estadillo->save();
            }
        } else {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Comprova el número de referència del nom del fitxer'));
        }
        //CREACIÓ DELS ACTORS DEL ESTADILLO
        //Fem la importació del excel utilitzant una classe Import, aquesta 
        //classe es del paquet de excel_laravel. Ubicació de la classe "App\Imports"
        $import = new ActorEstadilloImport($estadillo->id_estadillo);
                
        Excel::import($import, request()->file('import_file'));
        
        EstadilloController::updateCalendar($estadillo->registreProduccio->id_registre_entrada, $estadillo->registreProduccio->setmana);

        if (!empty($import->errors)) return redirect()->back()->with('error', $import->errors);
        
        return redirect()->back()->with('success', 'Estadillo importat correctament.');
    }
    
    public function insert()
    {
        $v = Validator::make(request()->all(), [
            'id_registre_produccio'   => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        }
        
        if (!RegistreProduccio::find(request()->input('id_registre_produccio'))){
            return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix aquest registre'));
        }
        
        $projecte = RegistreProduccio::find(request()->input('id_registre_produccio'));
        
        $estadillo = new Estadillo;
        $estadillo->id_registre_produccio=request()->input('id_registre_produccio');

        try {
            $estadillo->save(); 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
        }

        return redirect()->route('indexEstadillos')->with('success', 'Estadillo creat correctament.');
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
            }
            $projecte = RegistreProduccio::find(request()->input('id_registre_produccio'));

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
    
    
    public function insertActorView($id, $setmana=0){
        if ($setmana == 0){
            $estadillos = Estadillo::with('actors')->find($id);
            $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat as id_actor',
                                        'slb_empleats_externs.nom_empleat',
                                        'slb_empleats_externs.cognom1_empleat',
                                        'slb_empleats_externs.cognom2_empleat')
                            ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                            ->distinct()
                            ->where('slb_carrecs_empleats.id_carrec', 1)
                            ->whereNotExists(function($query) use ($id)
                                {
                                    $query->select('slb_actors_estadillo.id_actor')
                                          ->from('slb_actors_estadillo')
                                          ->whereRaw('slb_empleats_externs.id_empleat = slb_actors_estadillo.id_actor')
                                          ->where('slb_actors_estadillo.id_produccio', $id);
                                })
                            ->get();
                            
            return View('estadillos.createActor', array('empleats'=>$empleats, 'estadillos'=>$estadillos)); 
        } 
        
        $registreProduccio = RegistreProduccio::with('getEstadillo.actors')->where('id_registre_entrada', $id)->where('setmana', $setmana)->get();

        $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat as id_actor',
                                        'slb_empleats_externs.nom_empleat',
                                        'slb_empleats_externs.cognom1_empleat',
                                        'slb_empleats_externs.cognom2_empleat')
                            ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                            ->distinct()
                            ->where('slb_carrecs_empleats.id_carrec', 1)
                            ->whereNotExists(function($query) use ($id, $setmana)
                                {
                                    $query->select('slb_actors_estadillo.id_actor')
                                            ->from('slb_actors_estadillo')
                                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                                            ->whereRaw('slb_empleats_externs.id_empleat = slb_actors_estadillo.id_actor')
                                            ->where('slb_registres_produccio.id_registre_entrada', $id)
                                            ->where('slb_registres_produccio.setmana', $setmana);
                                })
                            ->get();

        return View('estadillos.createActor', array('empleats'=>$empleats, 'registreProduccio' => $registreProduccio));
    }

    public function insertActor($setmana = 0)
    {
        $v = Validator::make(request()->all(), [
                'id_actor'          => 'required'
        ]);
        
        if ($setmana == 0){
            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha elegit un actor'));
            }
            $actor = new ActorEstadillo(request()->all());               

            try {
                $actor->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut afegir l\'actor.'));
            }
            
            EstadilloController::updateCalendar($actor->estadillo->registreProduccio->id_registre_entrada, $actor->estadillo->registreProduccio->setmana);
            
            return redirect()->back()->with('success', 'Actor afegit correctament.');
        }
        
        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        }
        $estadillos= Estadillo::all();
        
        foreach ($estadillos as $estadillo){
            if (request()->has('take_estadillo_'.$estadillo->id_registre_produccio)){
                if (!ActorEstadillo::where('id_produccio',$estadillo->id_estadillo)->where('id_actor', request()->input('id_actor'))->first()){
                    $actor = new ActorEstadillo;
                    $actor->id_produccio=$estadillo->id_estadillo;
                    $actor->id_actor=request()->input('id_actor');
                    $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                    $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                    $actor->save();
                }
            }                    
        }
        
        EstadilloController::updateCalendar($actor->estadillo->registreProduccio->id_registre_entrada, $actor->estadillo->registreProduccio->setmana);
        
        return redirect()->back()->with('success', 'Actor afegit correctament.');
    }
    
    public function updateActorView($id, $id_actor, $setmana = 0) {            
        if ($setmana == 0){
            $empleats = EmpleatExtern::select('slb_empleats_externs.id_empleat as id_actor',
                                        'slb_empleats_externs.nom_empleat',
                                        'slb_empleats_externs.cognom1_empleat',
                                        'slb_empleats_externs.cognom2_empleat',
                                        'slb_actors_estadillo.take_estadillo',
                                        'slb_actors_estadillo.cg_estadillo',
                                        'slb_actors_estadillo.canso_estadillo',
                                        'slb_actors_estadillo.narracio_estadillo')
                            ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->where('slb_estadillo.id_estadillo', $id)
                            ->get();
             
            $estadillos = Estadillo::find($id);
           
            $actor = ActorEstadillo::where('id_produccio', $id)->where('id_actor', $id_actor)->first();

            return View('estadillos.createActor', array('actor'=> $actor,'empleats'=>$empleats, 'estadillos'=>$estadillos)); 
        } 
        
        $registreProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();

        $actor = array();
        
        foreach ($registreProduccio as $projecte){
            if (!empty($projecte->getEstadillo->actors)){
                $projecte->getEstadillo->actors;
                $actor = ActorEstadillo::where('id_produccio', $projecte->getEstadillo->id_estadillo)
                                                                ->where('id_actor', $id_actor)
                                                                ->first();

                break;
            }
        }
        
        $empleatsPack = EmpleatExtern::select('slb_empleats_externs.id_empleat as id_actor',
                                        'slb_empleats_externs.nom_empleat',
                                        'slb_empleats_externs.cognom1_empleat',
                                        'slb_empleats_externs.cognom2_empleat',
                                        'slb_actors_estadillo.take_estadillo',
                                        'slb_actors_estadillo.cg_estadillo',
                                        'slb_actors_estadillo.canso_estadillo',
                                        'slb_actors_estadillo.narracio_estadillo',
                                        'slb_registres_produccio.id_registre_entrada',
                                        'slb_registres_produccio.id as id_produccio',
                                        'slb_registres_produccio.setmana'
                )
                            ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                            ->where('slb_registres_produccio.id_registre_entrada', $id)
                            ->where('slb_registres_produccio.setmana', $setmana)
                            ->get();
        
        $empleats= EmpleatExtern::select('slb_empleats_externs.id_empleat as id_actor',
                                        'slb_empleats_externs.nom_empleat',
                                        'slb_empleats_externs.cognom1_empleat',
                                        'slb_empleats_externs.cognom2_empleat')
                            ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                            ->where('slb_registres_produccio.id_registre_entrada', $id)
                            ->where('slb_registres_produccio.setmana', $setmana)
                            ->distinct()
                            ->get();
        
        return view('estadillos.createActor', array('actor'=> $actor,'empleats'=> $empleats, 'empleatsPack'=> $empleatsPack,'registreProduccio'=> $registreProduccio));
    }

    public function updateActor($id, $id_actor, $setmana=0) {
        if ($setmana == 0) {
            $actor = ActorEstadillo::where('id_produccio',$id)->where('id_actor',request()->input('id_actor'))->first();
            if ($actor) {
                $actor->fill(request()->all());
                if (!request()->input('canso_estadillo')){
                    $actor->canso_estadillo = 0;
                }
                if (!request()->input('narracio_estadillo')){
                    $actor->narracio_estadillo = 0;
                }
                try {
                    $actor->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar l\'actor.'));
                }

                EstadilloController::updateCalendar($actor->estadillo->registreProduccio->id_registre_entrada, $actor->estadillo->registreProduccio->setmana);

                return redirect()->back()->with('success', 'Actor modificat correctament.');
            }  
        }

        $v = Validator::make(request()->all(), [
            'id_actor'          => 'required'
        ]);
        
        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            
            $estadillos= Estadillo::all();

            foreach ($estadillos as $estadillo){
                if (request()->has('take_estadillo_'.$estadillo->id_registre_produccio)){
                    $actor = ActorEstadillo::where('id_produccio', $estadillo->id_estadillo)
                                ->where('id_actor', request()->input('id_actor'))->first();

                    if (!$actor) {
                        $actor = new ActorEstadillo;
                        $actor->id_produccio=$estadillo->id_estadillo;
                        $actor->id_actor=request()->input('id_actor');
                        $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->canso_estadillo= request()->input('canso_estadillo_'.$estadillo->id_registre_produccio) ?? 0;
                        $actor->narracio_estadillo= request()->input('narracio_estadillo_'.$estadillo->id_registre_produccio) ?? 0;
                        $actor->save();
                    } else {
                        $actor->id_produccio=$estadillo->id_estadillo;
                        $actor->id_actor=request()->input('id_actor');
                        $actor->take_estadillo=request()->input('take_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->cg_estadillo=request()->input('cg_estadillo_'.$estadillo->id_registre_produccio);
                        $actor->canso_estadillo= request()->input('canso_estadillo_'.$estadillo->id_registre_produccio) ?? 0;
                        $actor->narracio_estadillo= request()->input('narracio_estadillo_'.$estadillo->id_registre_produccio) ?? 0;
                        $actor->save(); 
                    }
                }                    
            }
            
            EstadilloController::updateCalendar($actor->estadillo->registreProduccio->id_registre_entrada, $actor->estadillo->registreProduccio->setmana);
            
            return redirect()->back()->with('success', 'Actor afegit correctament.');
        }
    }

    public function find()
    {
        if (request()->input("searchBy") == '1'){
            $estadillos = Estadillo::all()->sortBy("id_registre_produccio");

            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
                if ($estadillo->registreProduccio->estadillo == request()->input("search_Validat")) {
                    if ($estadillo->registreProduccio->subreferencia!=0){
                        if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                'titol'=>$estadillo->registreProduccio->titol,
                                'setmana' => $estadillo->registreProduccio->setmana,
                                'min'=>$estadillo->registreProduccio->subreferencia,
                                'max'=>$estadillo->registreProduccio->subreferencia,
                                'validat'=>$estadillo->registreProduccio->estadillo
                            );
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
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'id_estadillo'=>$estadillo->id_estadillo,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'titol'=>$estadillo->registreProduccio->titol,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                    }
                }
            }
            
        }  else {
            $estadillos = Estadillo::all()->sortBy("id_registre_produccio");

            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
                if ($estadillo->registreProduccio->id_registre_entrada == request()->input("search_term") || preg_match('/'.request()->input("search_term").'/i' , $estadillo->registreProduccio->titol)) {
                    if ($estadillo->registreProduccio->subreferencia!=0){
                        if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                                'titol'=>$estadillo->registreProduccio->titol,
                                'setmana' => $estadillo->registreProduccio->setmana,
                                'min'=>$estadillo->registreProduccio->subreferencia,
                                'max'=>$estadillo->registreProduccio->subreferencia,
                                'validat'=>$estadillo->registreProduccio->estadillo
                            );
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
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'id_estadillo'=>$estadillo->id_estadillo,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'titol'=>$estadillo->registreProduccio->titol,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                    }
                }
            }
        }
        
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
        return View('estadillos.index', array('showEstadillos' => $showEstadillos, 'registreProduccio' => $registreProduccio,
                                                'return' => 1));
    }
    
    public function findActor($id, $id_setmana = 0){ //Funció per trobar a un actor
        $empleats = EmpleatExtern::whereRaw('LOWER(nom_empleat) like "%'. strtolower(request()->input("search_term")).'%"'
                                    . 'OR LOWER(cognom1_empleat) like "%'. strtolower(request()->input("search_term")).'%"'
                                    . 'OR LOWER(cognom2_empleat) like "%'. strtolower(request()->input("search_term")).'%"')->get();
        if ($id_setmana == 0){
            $actors = ActorEstadillo::where('id_produccio', $id)->get(); 

            $estadillos = Estadillo::find($id);
            $estadillos->registreProduccio;

            return new EstadilloShowActor($actors, $estadillos, $empleats);
        } 
        
        return new EstadilloShowActorSetmana($id, $id_setmana, $empleats);
    }
    
    public function delete(Request $request) //Funcio per esborrar un estadillo
    {
        ActorEstadillo::where('id_produccio', $request["id"])->delete();
        $estadillo = Estadillo::where('id_estadillo', $request["id"])->first();
        
        $id_registre_entarda = $estadillo->registreProduccio->id_registre_entarda;
        $setmana = $estadillo->registreProduccio->setmana;

        $produccio = RegistreProduccio::find($estadillo->id_registre_produccio);
        $produccio->estadillo = false;
        $produccio->save();
        
        $estadillo->delete();
        
        $this->updateCalendar($id_registre_entarda, $setmana);
        
        return redirect()->back()->with('success', 'Estadillo eliminat correctament.');
    }
    
    public function deleteActor(Request $request) //Funcio per esborrar un actor
    {
        $actor = ActorEstadillo::where('id', $request["id"])->first();
        
        $id_registre_entarda = $actor->estadillo->registreProduccio->id_registre_entarda;
        $setmana = $actor->estadillo->registreProduccio->setmana;

        $actor->delete();
        
        $this->updateCalendar($id_registre_entarda, $setmana);
        
        return redirect()->back()->with('success', 'Actor eliminat correctament.');
    }
    //Funcio per actualitzar el calendari apartir d'un registre d'entarda i una setmana
    public function updateCalendar($id_registre_entarda, $setmana) 
    {
        $actors = ActorEstadillo::select('slb_actors_estadillo.id_actor',
                                    DB::raw('SUM(slb_actors_estadillo.take_estadillo) as takes_totals'))
                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                            ->join('slb_registre_entrades', 'slb_registre_entrades.id_registre_entrada', 'slb_registres_produccio.id_registre_entrada')
                            ->groupBy('slb_actors_estadillo.id_actor')
                            ->where('slb_registres_produccio.id_registre_entrada', $id_registre_entarda)
                            ->where('slb_registres_produccio.setmana', $setmana)
                            ->get();

        foreach ($actors as $actor){
            $calendar = Calendar::where('id_registre_entrada', $id_registre_entarda)
                    ->whereSetmana($setmana)
                    ->where('id_actor', $actor->id_actor)
                    ->first();

            if ($calendar){
                $calendar->num_takes = $actor->takes_totals;

                $calendar->save();
            }
        }
    }
    
    public function getActors() {
        $actors = ActorEstadillo::select('slb_actors_estadillo.id_actor')
                                ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                                ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                                ->groupBy('slb_actors_estadillo.id_actor')
                                ->where('slb_registres_produccio.estat', 'Pendent')
                                ->get();                          

        return $actors;
    }
}
