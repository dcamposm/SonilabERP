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
        $estadillos = Estadillo::with('registreEntrades')->get();
        $registresEntrada = RegistreEntrada::all();
        return View('estadillos.index', array('estadillos' => $estadillos, 'registresEntrada' => $registresEntrada));
    }
    
    public function show($id){
        $actors = ActorEstadillo::where('id_estadillo', $id)->get();
        
        $empleats = EmpleatExtern::all();
        $estadillos = Estadillo::with('registreEntrades')->find($id);
        $registresEntrada = RegistreEntrada::all();
        //return response()->json($estadillos);
        return view('estadillos.show', array(
            'actors'    => $actors,
            'empleats'    => $empleats,
            'estadillos' => $estadillos,
            'registresEntrada' => $registresEntrada
        ));
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
        if (Projecte::where('id_registre_entrada', $idRegEntrada)->where('id_sub', $idRegProduccio)->first()){
            if (Estadillo::where('id_registre_entrada', $idRegEntrada)->where('id_registre_produccio', $idRegProduccio)->first()){
               return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut importar l\'estadillo. Aquet estadillo ja existeix'));
            } else {
                $registreEntrada =  RegistreEntrada::find($idRegEntrada);
                $estadillo = new Estadillo;
                $estadillo->tipus_media = $registreEntrada['id_media'];
                $estadillo->id_registre_entrada = $idRegEntrada;
                $estadillo->id_registre_produccio = $idRegProduccio;
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
        $estadillo = Estadillo::where('id_registre_entrada', $idRegEntrada)->where('id_registre_produccio', $idRegProduccio)->first();
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
        $medias = TipusMedia::all();
        return View('estadillos.create', array('medias'=>$medias));
    }

    public function insert()
    {
        //return response()->json(request()->all());
        $v = Validator::make(request()->all(), [
            'tipus_media'                 => 'required',
            'id_registre_entrada'         => 'required',
            'id_registre_produccio'       => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            
            if (RegistreEntrada::find(request()->input('id_registre_entrada'))){
                $estadillo = new Estadillo(request()->all());               

                try {
                    $estadillo->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el estadillo.'));
                }

                return redirect()->back()->with('success', 'Estadillo creat correctament.');
            } else {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No existeix la referecia o sub-referencia'));
            }
            
        }
    }
    
    public function updateView($id) {
        $estadillos = Estadillo::find($id);
        $medias = TipusMedia::all();
        return view('estadillos.create', array('estadillos'=> $estadillos,'medias'=> $medias));
    }

    public function update($id) {
        $estadillo = Estadillo::find($id);
        if ($estadillo) {
            $v = Validator::make(request()->all(), [
                'tipus_media'                 => 'required',
                'id_registre_entrada'         => 'required',
                'id_registre_produccio'       => 'required',
            ]);
    
            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
            } else {
                $estadillo->fill(request()->all());
    
                try {
                    $estadillo->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el estadillo.'));
                }
    
                return redirect()->back()->with('success', 'Estadillo modificat correctament.');
            }
        }
    }
    
    
    public function insertActorView($id){
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
        return View('estadillos.createActor', array('empleats'=>$empleats, 'estadillos'=>$estadillos));
    }

    public function insertActor()
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
    
    public function updateActorView($id) {
        $actor = ActorEstadillo::find($id);
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
        
        return view('estadillos.createActor', array('actor'=> $actor,'empleats'=> $empleats));
    }

    public function updateActor($id) {
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
