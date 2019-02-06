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
        $registreEntrades = RegistreEntrada::with('client')->get();
        return View('registre_entrada.index', array('registreEntrades' => $registreEntrades));
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
            'total_episodis'      => 'required',
            'episodis_setmanals'  => 'required',
            'entregues_setmanals' => 'required',
            'estat'               => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
        } else {
            $registreEntrada = new RegistreEntrada(request()->all());               

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
                'titol'               => 'required',
                'entrada'             => 'required',
                'sortida'             => 'required',
                'id_client'           => 'required',
                'id_servei'           => 'required',
                'id_idioma'           => 'required',
                'id_media'            => 'required',
                'minuts'              => 'required',
                'total_episodis'      => 'required',
                'episodis_setmanals'  => 'required',
                'entregues_setmanals' => 'required',
                'estat'               => 'required',
            ]);
    
            if ($v->fails()) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut modificar les dades.'));
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
        return view('registre_entrada.show', array('registreEntrada' => $registreEntrada));
        
    }
    public function delete(Request $request) {
        RegistreEntrada::where('id_registre_entrada', $request["id"])->delete();
        return redirect()->route('indexRegistreEntrada');
    }
}
