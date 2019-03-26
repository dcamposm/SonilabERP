<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\RegistreEntrada;
use App\Idioma;
use App\Client;
use App\Servei;
use App\TipusMedia;

class RegistreEntradaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $registreEntrades = RegistreEntrada::with('client')
                                ->with('servei')
                                ->with('idioma')
                                ->with('media')->orderBy("estat")->get();
        $clients = Client::all();
        $serveis = Servei::all();
        $idiomes = Idioma::all();
        $medies = TipusMedia::all();
        return View('registre_entrada.index', array('registreEntrades' => $registreEntrades, 'clients' => $clients,
                                                    'serveis' => $serveis, 'idiomes' => $idiomes, 'medies' => $medies));
    }
    
    public function find()
    {
        //return response()->json(request()->all());
        if (request()->input("searchBy") == '1'){  
            $registreEntrades = RegistreEntrada::where('id_client', request()->input("search_Client"))
                                                            ->orderBy(request()->input("orderBy"))->get();                     
        } else if (request()->input("searchBy") == '2'){
            $registreEntrades = RegistreEntrada::where('estat', request()->input("search_Estat"))
                                                    ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '3'){
            $registreEntrades = RegistreEntrada::where('entrada', request()->input("searchDate"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '4'){
            $registreEntrades = RegistreEntrada::where('sortida', request()->input("searchDate"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '5'){
            $registreEntrades = RegistreEntrada::where('id_servei', request()->input("search_Servei"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '6'){
            $registreEntrades = RegistreEntrada::where('id_idioma', request()->input("search_Idioma"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '7'){
            $registreEntrades = RegistreEntrada::where('id_media', request()->input("search_Media"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else if (request()->input("searchBy") == '8'){
            $registreEntrades = RegistreEntrada::where('minuts', request()->input("searchMin"))
                                                            ->orderBy(request()->input("orderBy"))->get();
        } else {
            $registreEntrades = RegistreEntrada::whereRaw('LOWER(titol) like "%'.strtolower(request()->input("search_term")).'%" '
                    . 'OR id_registre_entrada like "'.request()->input("search_term").'"')
                    ->orderBy(request()->input("orderBy"))->get();
                    //->orWhere('id_registre_entrada', request()->input("search_Estat"))->get();
        }
        
        $clients = Client::all();
        $serveis = Servei::all();
        $idiomes = Idioma::all();
        $medies = TipusMedia::all();
        //return redirect()->route('empleatIndex')->with('success', request()->input("searchBy").'-'.request()->input("search_term"));
        return view('registre_entrada.index',array('registreEntrades' => $registreEntrades, 'clients' => $clients,
                                                    'serveis' => $serveis, 'idiomes' => $idiomes, 'medies' => $medies));
    }

    public function insertView(){
        $clients = Client::all();
        $idiomes = Idioma::all();
        $serveis = Servei::all();
        $medias = TipusMedia::all();
        return View('registre_entrada.create', array('idiomes' => $idiomes, 'clients' => $clients,'serveis'=>$serveis,'medias'=>$medias));
    }

    public function insert()
    {
        $v = Validator::make(request()->all(), [
            'titol'               => 'required',
            'entrada'             => 'required',
            'sortida'             => 'required',
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
                $registreEntrada->entrada =request()->input('entrada');
                $registreEntrada->sortida =request()->input('sortida');
                $registreEntrada->id_client =request()->input('id_client');
                $registreEntrada->id_servei =request()->input('id_servei');
                $registreEntrada->id_idioma =request()->input('id_idioma');
                $registreEntrada->id_media =request()->input('id_media');
                $registreEntrada->minuts =request()->input('minuts');
                $registreEntrada->total_episodis =request()->input('total_episodis') ? request()->input('total_episodis') : '1';
                $registreEntrada->episodis_setmanals =request()->input('total_episodis') ? request()->input('total_episodis') : '1';
                $registreEntrada->entregues_setmanals =request()->input('total_episodis') ? request()->input('total_episodis') : '1';
                $registreEntrada->estat =request()->input('estat');
                $registreEntrada->save();
            }
                           

            try {
                $registreEntrada->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el registre d\'entrada.'));
            }

            return redirect()->back()->with('success', 'Registre d\'entrada creat correctament.');
        }
    }

    public function updateView($id) {
        $registreEntrada = RegistreEntrada::find($id);
        $clients = Client::all();
        $idiomes = Idioma::all();
        $serveis = Servei::all();
        $medias = TipusMedia::all();
        return view('registre_entrada.create', array(
            'registreEntrada' => $registreEntrada,
            'clients'         => $clients,
            'idiomes'         => $idiomes,
            'serveis'         => $serveis,
            'medias'          => $medias,
        ));
    }

    public function update($id) {
        $registreEntrada = RegistreEntrada::find($id);
        if ($registreEntrada) {
            $v = Validator::make(request()->all(), [
                'titol'           => 'required',
                'entrada'             => 'required',
                'sortida'             => 'required',
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
    
                try {
                    $registreEntrada->save(); 
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar el registre d\'entrada.'));
                }
    
                return redirect()->back()->with('success', 'Registre d\'entrada modificat correctament.');
            }
        }
    }
    
    public function show($id){
        $registreEntrada = RegistreEntrada::find($id);
        $idioma = Idioma::find($registreEntrada['id_idioma']);
        $client = Client::find($registreEntrada['id_client']);
        $servei = Servei::find($registreEntrada['id_servei']);
        $media = TipusMedia::find($registreEntrada['id_media']);
        return view('registre_entrada.show', array(
            'registreEntrada' => $registreEntrada,
            'client'          => $client,
            'servei'          => $servei,
            'media'           => $media,
            'idioma'          => $idioma
        ));
    }
    public function delete(Request $request) {
        RegistreEntrada::where('id_registre_entrada', $request["id"])->delete();
        return redirect()->route('indexRegistreEntrada');
    }
}
