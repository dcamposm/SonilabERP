<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\RegistreEntrada;
use App\Idioma;
use App\Client;
use App\Servei;
use App\TipusMedia;
use App\User;
use App\Missatge;
use App\RegistreProduccio;
use App\Estadillo;
use App\ActorEstadillo;
use App\Costos;
use App\EmpleatCost;
use App\Mail\RegistreEntradaCreat;
use App\Mail\RegistreEntradaUpdate;
use Illuminate\Support\Facades\Mail;
/*use Swift_Message;
use Swift_SmtpTransport;
use Swift_Mailer;*/
use View;
use App\Http\Responsables\RegistreEntrada\RegistreEntradaIndex;
use App\Http\Responsables\RegistreEntrada\RegistreEntradaCreate;
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
        //return response()->json(request()->all());
        if (request()->input("searchBy") == '1'){  
            $registreEntrades = RegistreEntrada::where('id_client', request()->input("search_Client"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();                     
        } else if (request()->input("searchBy") == '2'){
            $registreEntrades = RegistreEntrada::where('estat', request()->input("search_Estat"))
                                                    ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '3'){
            $registreEntrades = RegistreEntrada::where('id_usuari', request()->input("search_Resp"))
                                                    ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '4'){
            $registreEntrades = RegistreEntrada::where('sortida', request()->input("searchDate"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '5'){
            $registreEntrades = RegistreEntrada::where('id_servei', request()->input("search_Servei"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '6'){
            $registreEntrades = RegistreEntrada::where('id_idioma', request()->input("search_Idioma"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '7'){
            $registreEntrades = RegistreEntrada::where('id_media', request()->input("search_Media"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else if (request()->input("searchBy") == '8'){
            $registreEntrades = RegistreEntrada::where('minuts', request()->input("searchMin"))
                                                            ->orderBy(request()->input("orderBy"), 
                                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
        } else {
            $registreEntrades = RegistreEntrada::whereRaw('LOWER(titol) like "%'.strtolower(request()->input("search_term")).'%" '
                    . 'OR id_registre_entrada like "%'.request()->input("search_term").'%"')
                    ->orderBy(request()->input("orderBy"), 
                                                (request()->input("orderBy") == "id_registre_entrada" ? "DESC" : "ASC"))->get();
                    //->orWhere('id_registre_entrada', request()->input("search_Estat"))->get();
        }
        
        return new RegistreEntradaIndex($registreEntrades);
    }

    public function insertView(){
        return new RegistreEntradaCreate();
    }

    public function insert()
    {
        //return response()->json(request()->all());
        $v = Validator::make(request()->all(), [
            'titol'               => 'required',
            'sortida'             => 'required',
            'id_usuari'             => 'required',
            'id_client'           => 'required',
            'id_servei'           => 'required',
            'id_idioma'           => 'required',
            'id_media'            => 'required',
            'minuts'              => 'required',
            'estat'               => 'required',
        ],[
            'required' => 'No s\'ha introduït aquesta dada.',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
            //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            if (request()->input('id_registre_entrada')){
                $registreEntrada = new RegistreEntrada(request()->all());
            } else {
                $registreEntrada = new RegistreEntrada;
                $registreEntrada->ot = request()->input('ot') ? request()->input('ot') : '';
                $registreEntrada->oc =request()->input('oc') ? request()->input('oc') : '';
                $registreEntrada->titol =request()->input('titol');
                $registreEntrada->sortida =request()->input('sortida');
                $registreEntrada->id_usuari =request()->input('id_usuari');
                $registreEntrada->id_client =request()->input('id_client');
                $registreEntrada->id_servei =request()->input('id_servei');
                $registreEntrada->id_idioma =request()->input('id_idioma');
                $registreEntrada->id_media =request()->input('id_media');
                $registreEntrada->minuts =request()->input('minuts');
                $registreEntrada->total_episodis =request()->input('total_episodis') ? request()->input('total_episodis') : '1';
                $registreEntrada->episodis_setmanals =request()->input('episodis_setmanals') ? request()->input('episodis_setmanals') : '1';
                $registreEntrada->entregues_setmanals =request()->input('entregues_setmanals') ? request()->input('entregues_setmanals') : '1';
                $registreEntrada->estat =request()->input('estat');
                //$registreEntrada->save();
                
            }
            //return response()->json(date("Y-m-d",strtotime($registreEntrada->sortida."+ 7 days")));
            //return response()->json($registreEntrada->episodis_setmanals);
            try {
                $registreEntrada->save();                 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el registre d\'entrada.'));
            }
//---------------------Creador registres de produccio-------------------            
            if ($registreEntrada->id_media>1 && $registreEntrada->id_media<5) {
                //-----------Si el registre es una pelicula-----------
                $registreProduccio = new RegistreProduccio;
                $registreProduccio->subreferencia = 0;
                $registreProduccio->id_registre_entrada = $registreEntrada->id_registre_entrada;
                $registreProduccio->data_entrega = $registreEntrada->sortida;
                $registreProduccio->setmana = 1;
                $registreProduccio->titol = $registreEntrada->titol;
                $registreProduccio->save(); 
                //--------------------Misstage NEW per el responsable-----------------------
                $fecha_actual = date("d-m-Y");
                //return response()->json(date("d-m-Y",strtotime($fecha_actual."+ 7 days")));               
                $missatge = new Missatge;
                $missatge->id_usuari = request()->input('id_usuari');
                $missatge->missatge = "NEW";
                $missatge->referencia ='registreProduccio';
                $missatge->id_referencia =$registreProduccio->id;
                $missatge->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
                $missatge->save(); 
            } else {
                //-------Si el registre es una serie o documental------
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
                    //$registreProduccio->data_entrega = $registreEntrada->sortida;
                    if ($contNextSet <  $registreEntrada->episodis_setmanals){
                        $registreProduccio->setmana = $contSet;
                        $contNextSet++;
                    } else {
                        $contSet++;
                        $contNextSet = 1;
                        $registreProduccio->setmana = $contSet;
                    }
                    $registreProduccio->titol = $registreEntrada->titol;
                    $registreProduccio->save();
                    
                    //--------------------Misstage NEW per el responsable-----------------------
                    $fecha_actual = date("d-m-Y");
                    //return response()->json(date("d-m-Y",strtotime($fecha_actual."+ 7 days")));               
                    $missatge = new Missatge;
                    $missatge->id_usuari = request()->input('id_usuari');
                    $missatge->missatge = "NEW";
                    $missatge->referencia ='registreProduccio';
                    $missatge->id_referencia =$registreProduccio->id;
                    $missatge->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
                    $missatge->save(); 
                }
            }
//--------------------Misstage per el responsable-----------------------
            $fecha_actual = date("d-m-Y");
            //return response()->json(date("d-m-Y",strtotime($fecha_actual."+ 7 days")));               
            $missatge = new Missatge;
            $missatge->id_usuari = request()->input('id_usuari');
            $missatge->missatge = "S'ha creat el registre d'entrada: ".$registreEntrada->id_registre_entrada." ".$registreEntrada->titol;
            $missatge->referencia ='registreEntrada';
            $missatge->id_referencia =$registreEntrada->id_registre_entrada;
            $missatge->data_final =date("Y-m-d",strtotime($fecha_actual."+ 7 days"));
            $missatge->save(); 
//-------------------------------Email Exemple 1 amb Swift_Mailer----------------------------------
            /*// Create the Transport
            $transport = (new Swift_SmtpTransport('smtp-mail.outlook.com', 587, 'tls'))
              ->setUsername('dcampos@paycom.es')
              ->setPassword('')//Posar contrasenya de la conta
            ;            
            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
                     
            $registreEntrada = RegistreEntrada::find($registreEntrada->id_registre_entrada);
            
            $view = View::make('registre_entrada.email', array(
                'registreEntrada' => $registreEntrada
            ));
            $html = $view->render();
            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
              ->setFrom('dcampos@paycom.es')
              ->setTo('dcampos@paycom.es')
              ->setBody($html, 'text/html')
              ;

            // Send the message
            $result = $mailer->send($message);*/
//-------------------------------Email Exemple 2 amb Model Mail----------------------------------
            /*$registreEntrada = RegistreEntrada::find($registreEntrada->id_registre_entrada);

            Mail::to('dcampos@paycom.es')->send(new RegistreEntradaCreat($registreEntrada));*/
            
            return redirect()->back()->with('success', 'Registre d\'entrada creat correctament.');
        }
    }

    public function updateView($id) {
        $registreEntrada = RegistreEntrada::find($id);
        
        return new RegistreEntradaCreate($registreEntrada);
    }

    public function update($id) {
        //return response()->json(request()->all());
        $registreEntrada = RegistreEntrada::find($id);
        
        if ($registreEntrada) {
            $v = Validator::make(request()->all(), [
                'titol'               => 'required',
                'sortida'             => 'required',
                'id_usuari'           => 'required',
                'id_client'           => 'required',
                'id_servei'           => 'required',
                'id_idioma'           => 'required',
                'id_media'            => 'required',
                'minuts'              => 'required',
                'estat'               => 'required',
            ],[
                'required' => 'No s\'ha introduït aquesta dada.',
            ]);

            if ($v->fails()) {
                return redirect()->back()->withErrors($v)->withInput();
                //return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
            } else {
                $registreEntrada->fill(request()->all());
                
                /*$registre = RegistreEntrada::find($id);
                $mail = new RegistreEntradaUpdate($registre,$registreEntrada);*/
                //return response()->json($registreEntrada->getDirty());//El getDirty() serveix per veure els atributs modificats.
                try {
                    $registreEntrada->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el registre d\'entrada.'));
                }
    //-------------------------------Email amb Model Mail----------------------------------
                //Mail::to('dcampos@paycom.es')->send($mail);
                return redirect()->back()->with('success', 'Registre d\'entrada modificat correctament.');
            }
        }
    }
    
    public function show($id){
        $registreEntrada = RegistreEntrada::find($id);

        return view('registre_entrada.show', array(
            'registreEntrada' => $registreEntrada
        ));
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
        
        //return response()->json($estadillos); 
        RegistreEntrada::where('id_registre_entrada', $request["id"])->delete();
        //Elimina tots els missatges relacionats amb el registre d'Entrada que s'eliminara
        $registres = RegistreProduccio::where('id_registre_entrada', $request["id"])->get();
        foreach ($registres as $registre) {
            Missatge::where('id_referencia', $registre->id)->where('referencia', 'registreProduccio')->delete();
        }
        //Elimina tots els registres de producció relacionats amb el registre d'Entrada que s'eliminara
        $registres = RegistreProduccio::where('id_registre_entrada', $request["id"])->delete();
        Missatge::where('id_referencia', $request["id"])->where('referencia', 'registreEntrada')->delete();
        
        return redirect()->route('indexRegistreEntrada');
    }
}
