<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\{RegistreEntrada,Missatge,RegistreProduccio,Estadillo,ActorEstadillo,Costos,EmpleatCost,Calendar};
use App\Mail\{RegistreEntradaCreat, RegistreEntradaUpdate};
use App\Http\Responsables\RegistreEntrada\{RegistreEntradaIndex,RegistreEntradaCreate, RegistreEntradaShow};
use App\Http\Requests\RegistreEntradaCreateRequest;

class RegistreEntradaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $registreEntrades = RegistreEntrada::orderBy("estat")->orderBy("id_registre_entrada", "DESC")->get();
        
        return new RegistreEntradaIndex($registreEntrades);
    }
    
    public function find()
    {
        $registreEntrades = RegistreEntrada::orderBy("estat")
            ->orderBy(request()->input("orderBy"), (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))
            ->whereRaw('LOWER('.request()->input("searchBy").') like "%'.strtolower(request()->input("search_term")).'%"')->get();
        
        return new RegistreEntradaIndex($registreEntrades);
    }
    
    public function search(Request $request)
    {
        $registreEntrades = RegistreEntrada::all();
        
        return \response()->json($registreEntrades);
    }

    public function insertView(){
        return new RegistreEntradaCreate();
    }

    public function insert(RegistreEntradaCreateRequest $request)
    {
        $registreEntrada = new RegistreEntrada(request()->all());
        
        try {
            $registreEntrada->save();                 
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el registre d\'entrada.'));
        }
//---------------------Creador registres de produccio----------------------           
        if ($registreEntrada->id_media>1 && $registreEntrada->id_media<5) {
        //----------------Si el registre es una pelicula----------------
            $registreProduccio = new RegistreProduccio;
            $registreProduccio->createRegistrePelicula($registreEntrada); 
            $registreProduccio->save();
        //----------------Misstage NEW per el responsable---------------
            $missatge = new Missatge;
            $missatge->missatgeNewRegistre($registreEntrada, $registreProduccio); 
            $missatge->save(); 
        //----------------Misstage Entrega per el responsable---------------
            $missatge = new Missatge;
            $missatge->missatgeEntregaPeliculaRegistre($registreEntrada, $registreProduccio); 
            $missatge->save(); 
        } else {
        //-----------Si el registre es una serie o documental----------
            $contSet = 1;
            $contNextSet = 0;
            $contData = 0; 
            $contNextData = 0;
            for ($i=1; $i<=$registreEntrada->total_episodis; $i++){
                $registreProduccio = new RegistreProduccio;
                $registreProduccio->subreferencia = $i;
                $registreProduccio->id_registre_entrada = $registreEntrada->id_registre_entrada;

                if ($contNextData <  $registreEntrada->entregues_setmanals){
                    $registreProduccio->data_entrega = date("Y-m-d",strtotime($registreEntrada->sortida."+ $contData days"));
                    $contNextData++;
                } else {
                    $contData+=7;
                    $contNextData = 1;
                    $registreProduccio->data_entrega = date("Y-m-d",strtotime($registreEntrada->sortida."+ $contData days"));
                }
                if ($contNextSet <  $registreEntrada->episodis_setmanals){
                    $registreProduccio->setmana = $contSet;
                    $contNextSet++;
                } else {
                    $contSet++;
                    $contNextSet = 1;
                    $registreProduccio->setmana = $contSet;
                }
                
                if ($contNextSet == 1){
                //----------------Misstage Entrega Pack per el responsable---------------
                    $missatge = new Missatge;
                    $missatge->missatgeEntregaPackRegistre($registreEntrada, $registreProduccio,$contSet); 
                    $missatge->save();
                }
                
                $registreProduccio->titol = $registreEntrada->titol;
                $registreProduccio->save();

                //--------------------Misstage NEW per el responsable-----------------------
                $missatge = new Missatge;
                $missatge->missatgeNewRegistre($registreEntrada, $registreProduccio); 
                $missatge->save(); 
            }
        }
//--------------------Misstage per el responsable-----------------------
        $missatge = new Missatge;
        $missatge->missatgeResponsableRegistreCreate($registreEntrada);
        $missatge->save(); 
//------------------Email amb Model Mail (No Borrar)--------------------
        /*$registreEntrada = RegistreEntrada::find($registreEntrada->id_registre_entrada);

        Mail::to('dcampos@paycom.es')->send(new RegistreEntradaCreat($registreEntrada));*/

        return redirect()->back()->with('success', 'Registre d\'entrada creat correctament.');
    }

    public function updateView($id) {
        $registreEntrada = RegistreEntrada::find($id);
               
        return new RegistreEntradaCreate($registreEntrada);
    }

    public function update(RegistreEntradaCreateRequest $request, $id) {
        //return response()->json(request()->all());
        $registreEntrada = RegistreEntrada::find($id);
        
        if ($registreEntrada) {
            $registreEntrada->fill(request()->all());

            /*$registre = RegistreEntrada::find($id);//registre que s'utilitza per comprovar las dades. S'utilitza en el mail
            $mail = new RegistreEntradaUpdate($registre,$registreEntrada);//Creacio del contingut del mail*/
            //return response()->json($registreEntrada->getDirty());//El getDirty() serveix per veure els atributs modificats.
            $modificat = $registreEntrada->getDirty();
            try {
                $registreEntrada->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el registre d\'entrada.'));
            }
            //return response()->json($modificat);
//-------------------------------Missatge per responsable de modificacions----------------------------------     
            Missatge::where([['id_referencia', $registreEntrada->id_registre_entrada],
                        ['type', 'registreEntradaUpdate'],
                        ['referencia', 'registreEntrada']])                   
                        ->delete();
            $missatge = new Missatge;
            $missatge->missatgeResponsableRegistreUpdate($registreEntrada);
            $missatge->save();
            
            foreach ($modificat as $key => $mod){
                $missatge = new Missatge;
                $missatge->missatgeResponsableRegistreUpdateCamp($registreEntrada, $key);
                $missatge->save();
            }
//-------------------------------Email amb Model Mail----------------------------------
            //Mail::to('dcampos@paycom.es')->send($mail);
            return redirect()->back()->with('success', 'Registre d\'entrada modificat correctament.');
        }
    }
    
    public function show($id){
        $registreEntrada = RegistreEntrada::find($id);
        
        $missatge = Missatge::where([['id_referencia', $id],
                        ['type', 'registreEntradaUpdateCamp'],
                        ['referencia', 'registreEntrada']])                   
                        ->get();
        if ($registreEntrada->id_usuari == Auth::user()->id_usuari){
            Missatge::where([['id_referencia', $id],
                        ['type', 'registreEntradaUpdateCamp'],
                        ['referencia', 'registreEntrada']])                   
                        ->delete();
            Missatge::where([['id_referencia', $id],
                        ['type', 'registreEntradaUpdate'],
                        ['referencia', 'registreEntrada']])                   
                        ->delete();
        }
        
        return new RegistreEntradaShow($registreEntrada, $missatge);
    }
    
    public function delete(Request $request) {
        //Elimina tots els estadillos relacionats amb el registre d'Entrada que s'eliminara
        $estadillos = Estadillo::all();
        foreach ($estadillos as $estadillo) {
            if ($estadillo->registreProduccio->id_registre_entrada == $request["id"]){
                ActorEstadillo::where('id_produccio', $estadillo->id_estadillo)->delete();
                $estadillo->delete();
            }
        }
        
        //Elimina tots els costos relacionats amb el registre d'Entrada que s'eliminara
        $costos = Costos::all();
        foreach ($costos as $cost) {
            if ($cost->registreProduccio->id_registre_entrada == $request["id"]){
                EmpleatCost::where('id_costos', $cost->id_costos)->delete();
                $cost->delete();
            }
        }
        
        $calendars = Calendar::all();
        foreach ($calendars as $calendar) {
            if ($calendar->id_registre_entrada == $request["id"]){
                $calendar->delete();
            }
        }
        
        RegistreEntrada::where('id_registre_entrada', $request["id"])->delete();
        //Elimina tots els missatges relacionats amb el registre d'Entrada que s'eliminara
        $registres = RegistreProduccio::where('id_registre_entrada', $request["id"])->get();
        foreach ($registres as $registre) {
            Missatge::where('id_referencia', $registre->id)->where('referencia', 'registreProduccio')->delete();
        }
        //Elimina tots els registres de producció relacionats amb el registre d'Entrada que s'eliminara
        $registres = RegistreProduccio::where('id_registre_entrada', $request["id"])->delete();
        Missatge::where('id_referencia', $request["id"])->whereReferencia('registreEntrada')->delete();
        
        return redirect()->route('indexRegistreEntrada');
    }
}
