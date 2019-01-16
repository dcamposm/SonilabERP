<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\EmpleatExtern;
use App\Idioma;
use App\IdiomaEmpleat;

class EmpleatExternController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $empleats = EmpleatExtern::all();
        return View('empleats_externs.index', array('empleats' => $empleats));
    }

    public function show($id) {
        $empleat = EmpleatExtern::find($id);
        $carrecs = $empleat->carrec;
        
        // Crea el objeto "carrecsEmpelat" para mostrar las tablas de cargos en el frontend
        $carrecsEmpelat = array();
        foreach($carrecs as $key => $carrec) {
            $idioma = $carrec->idioma;
            $carrecsEmpelat[$carrec->carrec->nom_carrec][$carrec->id] = array(
                'id_idioma' => (empty($idioma)) ? 0 : $idioma->id_idioma,
                'idioma' => (empty($idioma)) ? '' : $idioma->idioma,
                'empleat_homologat' => $carrec->empleat_homologat,
                'preu_carrec' => $carrec->preu_carrec
            );
        }

        return View('empleats_externs.show', array(
            'empleat'        => $empleat,
            'carrecsEmpelat' => $carrecsEmpelat
        ));
    }

    public function insertView() {
        $idioma = Idioma::select('idioma')->get();
        //return response()->json(['prpr'=>$idioma]);
        return View('empleats_externs.create', array('idiomes' => $idioma));
    }

    public function updateView($id) {
        // TODO: Controlar si l'empleat existeix o no per mostrar una página o un altre
        $empleat = EmpleatExtern::find($id);
        return View('empleats_externs.create', array('empleat' => $empleat));
    }

    public function insert() {
        $empleat = new EmpleatExtern(request()->all());
        return response()->json(["error" => request()->all()], 400);
        $v = Validator::make(request()->all(), [
            'nom_empleat' => 'required',
            'cognoms_empleat' => 'required',
            'sexe_empleat' => 'required',
            'nacionalitat_empleat' => 'required',
            'email_empleat' => 'required',
            'dni_empleat' => 'required',
            'telefon_empleat' => 'required',
            'direccio_empleat' => 'required',
            'codi_postal_empleat' => 'required',
            'naixement_empleat' => 'required',
            'nss_empleat' => 'required',
            'iban_empleat' => 'required'
        ]);

        if ($v->fails()){
            return response()->json(["error" => true], 400);
            //return response()->json(["error" => request()->all()], 400);
        } else {
            $empleat->save();

            if ($empleat){

                //ToDo: FALTA PONER QUE LOS VALORES EXISTAN EN LA BBDD Y CONTROLAR TIPO DE VALORES
                /*$v = Validator::make(request()->all(), [
                    'id_empleat' => 'required',
                    'id_carrec' => 'required',
                    'id_idioma' => 'required',
                    'empleat_homologat' => 'required',
                    'preu_carrec' => 'required',
                ]);*/

                if ($v->fails() == false) {
                    $camposCargos = ["director","tecnic_sala","ajustador","actor","traductor","linguista"];
                    $idiomas = ["Català", 'Castellà', "Anglès"];

                    $datos = [];

                    foreach ($camposCargos as $key => $value) {
                        if ($value == "director" || $value == "tecnic_sala" || $value == "ajustador"){
                            //COMPROBAR QUE LOS CAMPOS EXISTAN
                            $datos["preu_carrec"] = request()->input("preu_$value");
                        } else {
                            foreach ($idiomas as $key => $idioma) {
                                //IGUAL
                                $datos["preu_carrec"] = request()->input("preu_$value"."_$idioma);
                            }
                        }
                    }


                }

            }

            return $this->insertView();
        }
    }

    public function update($id) {
        $usuario = EmpleatExtern::find($id);

        if ($usuario){
            //ToDo: FALTA COMPLETAR VALIDATOR
            $v = Validator::make(request()->all(), [
                'nom_empleat' => 'required',
                'cognoms_empleat' => 'required',
                'sexe_empleat' => 'required',
                'nacionalitat_empleat' => 'required',
                'email_empleat' => 'required',
                'dni_empleat' => 'required',
                'telefon_empleat' => 'required',
                'direccio_empleat' => 'required',
                'codi_postal_empleat' => 'required',
                'naixement_empleat' => 'required',
                'nss_empleat' => 'required',
                'iban_empleat' => 'required'
            ]);

            if ($v->fails()){
                return response()->json(["error" => true], 400);
            } else {
                $data = request()->all();
                if (!isset($data['actor'])){
                    $data['actor'] = 0;
                }
                if (!isset($data['director'])){
                    $data['director'] = 0;
                }
                if (!isset($data['tecnic_sala'])){
                    $data['tecnic_sala'] = 0;
                }
                if (!isset($data['traductor'])){
                    $data['traductor'] = 0;
                }
                if (!isset($data['ajustador'])){
                    $data['ajustador'] = 0;
                }
                if (!isset($data['linguista'])){
                    $data['linguista'] = 0;
                }

                $usuario->fill($data);
                $usuario->save();
                return $this->index();
            }
        }
    }

    public function delete(Request $request) {
        EmpleatExtern::where('id_empleat',$request["id"])->delete();
        return $this->index();
    }
}
