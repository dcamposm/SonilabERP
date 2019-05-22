<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Estadillo,RegistreProduccio,ActorEstadillo,EmpleatExtern,CarrecEmpleat};
use Excel;
use Validator;
use App\Http\Responsables\Estadillo\{EstadilloIndex,EstadilloShowActor,EstadilloShowActorSetmana};

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
            //return response()->json($estadillos);
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
        //return response()->json($registreProduccio);
        
        foreach($registreProduccio as $registre){
            $registre->getEstadillo;
        }
        //return response()->json($registreProduccio);      
        
        return View('estadillos.show', array('registreProduccio'=>$registreProduccio));
    }
    
    public function import() 
    {
        //return response()->json(request()->input('id_estadillo'));
        if (!request()->input('id_estadillo')){
            if (request()->has('import_file')) {
                $titol = request()->file('import_file')->getClientOriginalName();
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha introduit un excel'));
            }

            $arrayTitol = explode('_', $titol);
            $idRegEntrada = $arrayTitol[0];
            $idRegProduccio = $arrayTitol[1];
            //return response()->json(Projecte::where('id_registre_entrada', $idRegEntrada)->where('id', $idRegProduccio)->get());

            $projecte = RegistreProduccio::where('id_registre_entrada', $idRegEntrada)
                    ->where('subreferencia', $idRegProduccio)->first();
        } else {
            $projecte = RegistreProduccio::where('id', request()->input('id_estadillo'))->first();
        }
        
        $estadillo = Estadillo::where('id_registre_produccio', $projecte['id'])->first();
        //CREACIO ESTADILLO
        if ($projecte){
            if ($estadillo){
               return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Aquest estadillo ja existeix'));
            } else {
                $projecte->estadillo = true;
                $projecte->save();
                $estadillo = new Estadillo;
                $estadillo->id_registre_produccio = $projecte['id'];
                $estadillo->save();
                //return response()->json('Estadillo creado');
            }
        } else {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Comprova el número de referència del nom del fitxer'));
        }
        //CREACIO ACTORS ESTADILLO
        //Pasem el excel en una array
        $excel = Excel::toArray(new Estadillo,request()->file('import_file'));
        //Agafem els valors de la primera Fulla i els guardem en una Array
        $arrayEstadillo = $excel[0];
        //return response()->json($arrayEstadillo);
        //Recorem tota l'array amb les dades del excel, en la $i indiquem la fila on esta el valors
        for ($i = 1; $i < count($arrayEstadillo); $i++){
            //return response()->json($nomCognom);
            //Comprovació si existeix el actor
            if (!is_null($arrayEstadillo[$i][1])){
                $empleat = EmpleatExtern::whereRaw('LOWER(nom_empleat) like "%'. strtolower($arrayEstadillo[$i][1]).'%"'
                                                . 'AND LOWER(cognom1_empleat) like "%'. strtolower($arrayEstadillo[$i][0]).'%"')->first();
            
                if ($empleat){
                    //return response()->json($empleat);
                    $actor = ActorEstadillo::where('id_produccio', $estadillo['id_estadillo'])
                            ->where('id_actor', $empleat['id_empleat'])->first();
                    //return response()->json($actor);
                    if ($actor){
                        $actor->id_produccio = $estadillo['id_estadillo'];
                        $actor->id_actor = $empleat['id_empleat'];
                        $actor->take_estadillo = $arrayEstadillo[$i][2];
                        $actor->cg_estadillo = $arrayEstadillo[$i][3];
                        $actor->canso_estadillo = is_null($arrayEstadillo[$i][4]) ? 0 : 1;
                        $actor->narracio_estadillo = is_null($arrayEstadillo[$i][5]) ? 0 : 1;
                        $actor->save();
                    } else {
                        $actor = new ActorEstadillo;
                        $actor->id_produccio = $estadillo['id_estadillo'];
                        $actor->id_actor = $empleat['id_empleat'];
                        $actor->take_estadillo = $arrayEstadillo[$i][2];
                        $actor->cg_estadillo = $arrayEstadillo[$i][3];
                        $actor->canso_estadillo = is_null($arrayEstadillo[$i][4]) ? 0 : 1;
                        $actor->narracio_estadillo = is_null($arrayEstadillo[$i][5]) ? 0 : 1;
                        $actor->save();
                    }
                    //return response()->json($actor);
                } else {
                    if (!isset($alert)){
                        $alert = "WARNING. Aquests actors no existeixen o no s'han trobat: ";
                    }
                    $alert = $alert."".$arrayEstadillo[$i][1]." ".$arrayEstadillo[$i][0] . ", ";
                    //return response()->json('ERROR. No existeix '.$nomCognom[1].' '.$nomCognom[0]);
                }
            }
        }
        //return response()->json($nomCognom);
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
        
        //return response()->json($empleats);
        if ($setmana == 0){
           $estadillos = Estadillo::with('actors')->find($id);
            //Despres introdueix en una altre array, tots els atributs del empleat
            for ($i = 0; $i < count($empleatsArray); $i++){
                $ext = false;
                foreach ($estadillos->actors as $actor) {
                    if ($actor->id_actor == $empleatsArray[$i]){
                        $ext = true;
                    }
                }
                if ($ext == false) {
                    $empleats[$i] =  EmpleatExtern::where('id_empleat', $empleatsArray[$i])->first();
                }
            } 
            return View('estadillos.createActor', array('empleats'=>$empleats, 'estadillos'=>$estadillos)); 
        } 
        
        $registreProduccio = RegistreProduccio::with('getEstadillo.actors')->where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        //return response()->json($registreProduccio);
        //Despres introdueix en una altre array, tots els atributs del empleat
        for ($i = 0; $i < count($empleatsArray); $i++){
            $ext = false;
            foreach ($registreProduccio as $registre) {
                if (!empty($registre->getEstadillo->actors)) {
                    foreach ($registre->getEstadillo->actors as $actor) {
                        if ($actor->id_actor == $empleatsArray[$i]){
                            $ext = true;
                        }
                    }
                }
            }
            if ($ext == false) {
                $empleats[$i] =  EmpleatExtern::where('id_empleat', $empleatsArray[$i])->first();
            }
        } 

        //return response()->json($empleats);
        return View('estadillos.createActor', array('empleats'=>$empleats, 'registreProduccio' => $registreProduccio));
        
    }

    public function insertActor($setmana = 0)
    {
        //return response()->json(request()->all());
        if ($setmana == 0){
           $v = Validator::make(request()->all(), [
                'id_actor'          => 'required'
            ]);

            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha elegit un actor'));
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
            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
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
            $showEstadillos = array();

            foreach ($estadillos as $estadillo){
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
            //return response()->json($empleats);
            $estadillos = Estadillo::find($id);
            $estadillos->registreProduccio;
            //return response()->json($estadillos);
            return new EstadilloShowActor($actors, $estadillos, $empleats);
        } 
        
        return new EstadilloShowActorSetmana($id, $id_setmana, $empleats);
    }
    
    public function delete(Request $request) //Funcio per esborrar un estadillo
    {
        ActorEstadillo::where('id_produccio', $request["id"])->delete();
        $estadillo = Estadillo::where('id_estadillo', $request["id"])->first();
        //return response()->json($estadillo);
        $produccio = RegistreProduccio::find($estadillo->id_registre_produccio);
        $produccio->estadillo = false;
        $produccio->save();
        $estadillo->delete();
        return redirect()->back()->with('success', 'Estadillo eliminat correctament.');
    }
    
    public function deleteActor(Request $request) //Funcio per esborrar un actor
    {
        ActorEstadillo::where('id', $request["id"])->delete();
        return redirect()->back()->with('success', 'Actor eliminat correctament.');
    }
}
