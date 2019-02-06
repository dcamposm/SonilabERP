<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $clients = Client::select('nom_client')->get();
        $idiomes = Idioma::select('idioma')->get();
        $serveis = Servei::select('nom_servei')->get();
        $medias = TipusMedia::select('nom_media')->get();
        return View('registre_entrada.create', array('idiomes' => $idiomes, 'clients' => $clients,'serveis'=>$serveis,'medias'=>$medias));
    }

    public function insert()
    {
        // return response()->json(["error" => request()->all()], 400);
        $v = Validator::make(request()->all(), [
            'ref_registre_entrada' => 'required',
            'titol_registre_entrada' => 'required',
            'entrada_registre_entrada' => 'required',
            'sortida_registre_entrada' => 'required',
            'client_registre_entrada' => 'required',
            'servei_registre_entrada' => 'required',
            'idioma_registre_entrada' => 'required',
            'tipus_registre_entrada' => 'required',
            'episodis_totals_registre_entrada' => 'required',
            'episodis_setmanals_registre_entrada' => 'required',
            'entregues_setmanals_registre_entrada' => 'required',
            'estat_registre_entrada' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
            //return response()->json(["error" => true], 400);
            //return response()->json(["error" => request()->all()], 400);
        } else {
            $registreEntrada = new RegistreEntrada(request()->all());               

            try {
                $registreEntrada->save(); 
            } catch (\Exception $ex) {
                return redirect()->back()->withErrors(array('error' => 'ERROR. El email, dni o nss ja existeixen'));
            }

            if ($registreEntrada) {

                //ToDo: FALTA PONER QUE LOS VALORES EXISTAN EN LA BBDD Y CONTROLAR TIPO DE VALORES
                /*$v = Validator::make(request()->all(), [
                'id_empleat' => 'required',
                'id_carrec' => 'required',
                'id_idioma' => 'required',
                'empleat_homologat' => 'required',
                'preu_carrec' => 'required',
                ]);*/

                $camposClient = Client::all(); 
                $idiomas = Idioma::all(); //["Català", 'Castellà', "Anglès"];

                $datos = [];

                foreach ($camposClient as $key => $client) {
                    $id_client = $client->id_client;
                    $nomClient = $client->input_name;

                    if (($nomCarrec == "director" || $nomCarrec == "tecnic_sala") && request()->has($nomCarrec)) {
                        $datos["id_empleat"] = $registreEntrada->id_empleat;
                        $datos["id_carrec"] = $id_carrec;
                        $datos["id_idioma"] = 0;
                        $datos["empleat_homologat"] = 0;
                        $datos["preu_carrec"] = (request()->has("preu_$nomCarrec")) ? request()->input("preu_$nomCarrec") : 0;

                        $carrecEmpleat = new CarrecEmpleat($datos);
                        // TODO: Validar "carrecEmpleat"
                        $carrecEmpleat->save();
                    } else if (request()->has($nomCarrec)) {
                        foreach ($idiomas as $key => $idioma) {
                            $id_idioma = $idioma->id_idioma;
                            $nom_idioma = $idioma->idioma;

                            if (request()->has("idioma_$nomCarrec" . "_$nom_idioma")) {
                                $datos["id_empleat"] = $registreEntrada->id_empleat;
                                $datos["id_carrec"] = $id_carrec;
                                $datos["id_idioma"] = $id_idioma;
                                $datos["empleat_homologat"] = request()->input("homologat_$nomCarrec" . "_$nom_idioma");
                                $datos["preu_carrec"] = (request()->has("preu_$nomCarrec" . "_$nom_idioma")) ? request()->input("preu_$nomCarrec" . "_$nom_idioma") : 0;

                                $carrecEmpleat = new CarrecEmpleat($datos);
                                // TODO: Validar "carrecEmpleat"
                                $carrecEmpleat->save();
                            }
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'S\'ha creat el personal correctament');
        }
    }

    public function updateView($id) {
        $registreEntrada = RegistreEntrada::find($id);
        return view('registre_entrada.create', array('registreEntrada' => $registreEntrada));
    }

    public function update() {
        // TODO: Actualizar registro de entrada.

    }
    
    public function show(){
        $registreEntrada = RegistreEntrada::findOrFind($id);
        $idioma = Idioma::findOrFind($registreEntrada['id_idioma']);
        $client = Client::findOrFind($registreEntrada['id_client']);
        $servei = Servei::findOrFind($registreEntrada['id_servei']);
        $media = Media::findOrFind($registreEntrada['id_media']);
        return view('registre_entrada.show', array('registreEntrada' => $registreEntrada), array('idioma' => $idioma), array('client' => $client), array('servei' => $servei), array('media' => $media));
        
    }
    public function delete(Request $request) {
        RegistreEntrada::where('id_registre_entrada', $request["id"])->delete();
        return redirect()->route('indexRegistreEntrada');
    }
}
