<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estadillo;
use App\RegistreEntrada;
use App\Projecte;
use App\ActorEstadillo;
use App\EmpleatExtern;
use App\CarrecEmpleat;
use App\Carrec;
use App\TipusMedia;
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
        $estadillos = Estadillo::all();
        //return response()->json($estadillos[1]->registreProduccio);
        //$registreProduccio = Projecte::all();
        $showEstadillos = array();
        
        foreach ($estadillos as $estadillo){
            //$projecte = Projecte::find($estadillo['id_registre_produccio']);
            //return response()->json($projecte);
            if ($estadillo->registreProduccio->id_sub!=0){
                //return response()->json($estadillo);
                if (!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                    $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                        'nom'=>$estadillo->registreProduccio->nom,
                        'setmana' => $estadillo->registreProduccio->setmana,
                        'min'=>$estadillo->registreProduccio->id_sub,
                        'max'=>$estadillo->registreProduccio->id_sub,
                        'validat'=>$estadillo->registreProduccio->estadillo
                    );
                } else {
                    if(!isset($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana])){
                        $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'nom'=>$estadillo->registreProduccio->nom,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'min'=>$estadillo->registreProduccio->id_sub,
                            'max'=>$estadillo->registreProduccio->id_sub,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                    } else {
                        if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max']<$estadillo->registreProduccio->id_sub){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max'] = $estadillo->registreProduccio->id_sub;
                        } else if ($showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min']>$estadillo->registreProduccio->id_sub){
                            $showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min'] = $estadillo->registreProduccio->id_sub;
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
                    'nom'=>$estadillo->registreProduccio->nom,
                    'validat'=>$estadillo->registreProduccio->estadillo
                );
                //return response()->json($showEstadillos);
            }
        }
        //return response()->json($showEstadillos);
        return View('estadillos.index', array('showEstadillos' => $showEstadillos));
    }
    
    public function show($id, $id_setmana = 0){
        $empleats = EmpleatExtern::all();
        if ($id_setmana == 0){
            $actors = ActorEstadillo::where('id_estadillo', $id)->get(); 
            $estadillos = Estadillo::find($id);
            $registreProduccio = $estadillos->registreProduccio;

            //return response()->json($estadillos);//['registre_produccio']
            //$registreProduccio = Projecte::find($estadillos['id_registre_produccio']);
            //return response()->json($estadillos);
            return view('estadillos.showActor', array(
                'actors'    => $actors,
                'empleats'    => $empleats,
                'registreProduccio' => $registreProduccio,
                'estadillos' => $estadillos
            ));
        } 
        
        $arrayActors = array();
        $registresProduccio = Projecte::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->get();
        
        //return response()->json($registresProduccio);
        
        foreach ($registresProduccio as $registre) {
            $estadillo = Estadillo::where('id_registre_produccio', $registre['id'])->first();
            //return response()->json($estadillos);
            if ($estadillo){
                //return response()->json($estadillos);
                $actors = ActorEstadillo::where('id_estadillo', $estadillo['id_estadillo'])->get();
                //return response()->json($actors);
                
                foreach ($actors as $actor) {  
                    if (!isset($arrayActors[$actor['id_actor']])){
                        $arrayActors[$actor['id_actor']] = array(
                            'id_actor' => $actor['id_actor'],
                            'cg_actor' =>  $actor['cg_actor'],
                            'take_estaillo' => $actor['take_estaillo']
                        );
                    } else {
                        $arrayActors[$actor['id_actor']]['cg_actor']+=$actor['cg_actor'];
                        $arrayActors[$actor['id_actor']]['take_estaillo']+=$actor['take_estaillo'];
                        //return response()->json($arrayActors);
                    }
                    //return response()->json($arrayActors);
                }  
                
                if (!isset($min)) {
                    $min = $registre['id_sub'];
                    $max = $registre['id_sub'];
                } else {
                    if ($registre['id_sub'] < $min){
                        $min = $registre['id_sub'];
                    } else if ($registre['id_sub'] > $max) {
                        $max = $registre['id_sub'];
                    }
                }
                $estadillos = Estadillo::where('id_registre_produccio', $registre['id'])->first()->registreProduccio;
            }
        }
        $registreProduccio = Projecte::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->first();
        
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
        $registreProduccio = Projecte::where('id_registre_entrada', $id)->where('setmana', $id_setmana)->first();
        
        $estadillo = Estadillo::where('setmana', $id_setmana)->where()->get();
        //return response()->json($estadillo);
        return View('estadillos.show', array('registreProduccio'=>$registreProduccio, 'estadillo' => $estadillo));
    }
    
    public function import() 
    {
        $titol = request()->file('import_file')->getClientOriginalName();
        $arrayTitol = explode('_', $titol);
        $idRegEntrada = $arrayTitol[0];
        $arrayRegProd = explode(' ', $arrayTitol[count($arrayTitol)-1]);
        $idRegProduccio = $arrayRegProd[0];
        //return response()->json(Projecte::where('id_registre_entrada', $idRegEntrada)->where('id', $idRegProduccio)->get());
        //CREACIO ESTADILLO
        $projecte = Projecte::where('id_registre_entrada', $idRegEntrada)->where('id_sub', $idRegProduccio)->first();
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
                $empleat = EmpleatExtern::where('nom_empleat', $nomCognom[1])->where('cognom1_empleat', $nomCognom[0])->first();
            } catch (\Exception $ex) {
                $empleat = EmpleatExtern::where('nom_empleat', $nomCognom[0])->first();
            }
            
            
            if ($empleat){ 
                //return response()->json('Existeix');
                $actor = new ActorEstadillo;
                $actor->id_estadillo = $estadillo['id_estadillo'];
                $actor->id_actor = $empleat['id_empleat'];
                $actor->take_estaillo = $arrayEstadillo[$i][1];
                $actor->save();
            } else {
                $alert = 'WARNING. No s\'ha pogut introduir tots els actors. Comprova si existeixen en \'GESTIÓ DE PERSONAL\'.';
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
    
    public function insertView(){
        $estadillos = Estadillo::all();
        $registreProduccio = Projecte::all();
        
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
        
        return View('estadillos.create', array('registreProduccio'=>$arrayProjectes));
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
            
            if (Projecte::find(request()->input('id_registre_produccio'))){
                $projecte = Projecte::find(request()->input('id_registre_produccio'));
                //return response()->json($projecte);
                $estadillo = new Estadillo;
                
                $estadillo->id_registre_produccio=request()->input('id_registre_produccio');
                $estadillo->save();
                
                try {
                    $estadillo->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }

                return redirect()->back()->with('success', 'Estadillo creat correctament.');
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix aquest registre'));
            }
            
        }
    }
    
    public function updateView($id) {
        $estadillosAll = Estadillo::all();
        $registreProduccio = Projecte::all();
        $estadillos = Estadillo::find($id);
        $arrayProjectes = array();
        $cont = 0;
 
        
        foreach ($registreProduccio as $projecte){
            $exist = false;
            foreach ($estadillosAll as $estadillo) {
                if ($projecte->id == $estadillo->id_registre_produccio && $projecte->id != $estadillos->id_registre_produccio){
                    $exist = true;
                }
            }
            if ($exist == false) {
                $arrayProjectes[$cont] = $projecte;
                $cont++;
            }
        }
        $registre = Estadillo::find($id)->registreProduccio;
        return view('estadillos.create', array('estadillos'=> $estadillos,'registreProduccio'=> $arrayProjectes, 'registre'=>$registre));
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
                $projecte = Projecte::find(request()->input('id_registre_produccio'));
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
    
    
    public function insertActorView($id, $setmana){
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
        
        $registreProduccio = Projecte::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        //return response()->json($registreProduccio);
        $estadillos = Estadillo::all();        
        $arrayProjectes = array();
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
        }
        
        //return response()->json($arrayProjectes);
        return View('estadillos.createActor', array('empleats'=>$empleats, 'registreProduccio' => $arrayProjectes));
        
    }

    public function insertActor($setamana = 0)
    {
        //return response()->json(request()->all());
        $v = Validator::make(request()->all(), [
            'id_actor'          => 'required',
            'take_estaillo'     => 'required',
            'cg_actor'          => 'required',
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
    
    public function updateActorView($id, $id_actor) {
        $actor = ActorEstadillo::find($id_actor);
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
        $estadillos = Estadillo::find($id);
        return view('estadillos.createActor', array('actor'=> $actor,'empleats'=> $empleats, 'estadillos'=> $estadillos));
    }

    public function updateActor($id, $id_actor) {
        $actor = ActorEstadillo::find($id);
        if ($actor) {
            $v = Validator::make(request()->all(), [
                'id_actor'          => 'required',
                'take_estaillo'     => 'required',
                'cg_actor'          => 'required',
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
    
    public function delete(Request $request)
    {
        ActorEstadillo::where('id_estadillo', $request["id"])->delete();
        Estadillo::where('id_estadillo', $request["id"])->delete();
        return redirect()->route('indexEstadillos')->with('success', 'Estadillo eliminat correctament.');
    }
    
    public function deleteActor(Request $request)
    {
        ActorEstadillo::where('id', $request["id"])->delete();
        return redirect()->route('indexEstadillos')->with('success', 'Actor eliminat correctament.');
    }
}

