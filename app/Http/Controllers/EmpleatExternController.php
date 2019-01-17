<?php

namespace App\Http\Controllers;

use App\Carrec;
use App\CarrecEmpleat;
use App\EmpleatExtern;
use App\Idioma;
use Illuminate\Http\Request;
use Validator;

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

    public function index()
    {
        $empleats = EmpleatExtern::all();
        return View('empleats_externs.index', array('empleats' => $empleats));
    }

    public function show($id)
    {
        $empleat = EmpleatExtern::find($id);
        $carrecs = $empleat->carrec;

        // Crea el objeto "carrecsEmpelat" para mostrar las tablas de cargos en el frontend
        $carrecsEmpelat = array();
        foreach ($carrecs as $key => $carrec) {
            $idioma = $carrec->idioma;
            $carrecsEmpelat[$carrec->carrec->nom_carrec][$carrec->id] = array(
                'id_idioma' => (empty($idioma)) ? 0 : $idioma->id_idioma,
                'idioma' => (empty($idioma)) ? '' : $idioma->idioma,
                'empleat_homologat' => $carrec->empleat_homologat,
                'preu_carrec' => $carrec->preu_carrec,
            );
        }

        return View('empleats_externs.show', array(
            'empleat' => $empleat,
            'carrecsEmpelat' => $carrecsEmpelat,
        ));
    }

    public function insertView()
    {
        $idioma = Idioma::select('idioma')->get();
        //return response()->json(['prpr'=>$idioma]);
        return View('empleats_externs.create', array('idiomes' => $idioma));
    }

    public function updateView($id)
    {
        // TODO: Controlar si l'empleat existeix o no per mostrar una página o un altre
        $empleat = EmpleatExtern::find($id);
        $idioma = Idioma::select('idioma')->get();
        $carrecsEmpleats = $empleat->carrec;
        $carrecsData = [];

        foreach ($carrecsEmpleats as $key => $carrecEmp) {
            if ($carrecEmp->id_idioma == 0) {
                $carrecsData[$carrecEmp->carrec->input_name] = array(
                    'preu_carrec' => $carrecEmp->preu_carrec
                );
            }
            else {
                $carrecsData[$carrecEmp->carrec->input_name][$carrecEmp->idioma->idioma] = array(
                    'empleat_homologat' => $carrecEmp->empleat_homologat,
                    'preu_carrec' => $carrecEmp->preu_carrec
                );
            }
        }

        // return response()->json($carrecsData);

        return View('empleats_externs.create', array(
            'empleat' => $empleat,
            'idiomes' => $idioma,
            'carrecs' => $carrecsData
        ));
    }

    public function insert()
    {
        // return response()->json(["error" => request()->all()], 400);
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
            'iban_empleat' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json(["error" => true], 400);
            //return response()->json(["error" => request()->all()], 400);
        } else {
            $empleat = new EmpleatExtern(request()->all());
            $empleat->save();

            if ($empleat) {

                //ToDo: FALTA PONER QUE LOS VALORES EXISTAN EN LA BBDD Y CONTROLAR TIPO DE VALORES
                /*$v = Validator::make(request()->all(), [
                'id_empleat' => 'required',
                'id_carrec' => 'required',
                'id_idioma' => 'required',
                'empleat_homologat' => 'required',
                'preu_carrec' => 'required',
                ]);*/

                $camposCargos = Carrec::all(); //["director","tecnic_sala","ajustador","actor","traductor","linguista"];
                $idiomas = Idioma::all(); //["Català", 'Castellà', "Anglès"];

                $datos = [];

                foreach ($camposCargos as $key => $carrec) {
                    $id_carrec = $carrec->id_carrec;
                    $nomCarrec = $carrec->input_name;
                    
                    if (($nomCarrec == "director" || $nomCarrec == "tecnic_sala" || $nomCarrec == "ajustador") && request()->has($nomCarrec)) {
                        $datos["id_empleat"] = $empleat->id_empleat;
                        $datos["id_carrec"] = $id_carrec;
                        $datos["id_idioma"] = 0;
                        $datos["empleat_homologat"] = false;
                        $datos["preu_carrec"] = (request()->has("preu_$nomCarrec")) ? request()->input("preu_$nomCarrec") : 0;

                        $carrecEmpleat = new CarrecEmpleat($datos);
                        // TODO: Validar "carrecEmpleat"
                        $carrecEmpleat->save();
                    } else if (request()->has($nomCarrec)) {
                        foreach ($idiomas as $key => $idioma) {
                            $id_idioma = $idioma->id_idioma;
                            $nom_idioma = $idioma->idioma;

                            if (request()->has("idioma_$nomCarrec" . "_$nom_idioma")) {
                                $datos["id_empleat"] = $empleat->id_empleat;
                                $datos["id_carrec"] = $id_carrec;
                                $datos["id_idioma"] = $id_idioma;
                                $datos["empleat_homologat"] = (request()->has("homologat_$nomCarrec" . "_$nom_idioma")) ? request()->input("homologat_$nomCarrec" . "_$nom_idioma") : false;
                                $datos["preu_carrec"] = (request()->has("preu_$nomCarrec" . "_$nom_idioma")) ? request()->input("preu_$nomCarrec" . "_$nom_idioma") : 0;
    
                                $carrecEmpleat = new CarrecEmpleat($datos);
                                // TODO: Validar "carrecEmpleat"
                                $carrecEmpleat->save();
                            }
                        }
                    }
                }
            }

            return $this->insertView();
        }
    }

    public function update($id)
    {
        $usuario = EmpleatExtern::find($id);

        if ($usuario) {
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

            if ($v->fails()) {
                return response()->json(["error" => true], 400);
            } else {
                // Modifica datos personales del empleado
                $data = request()->all();
                $usuario->fill($data);
                $usuario->save();

                // Modifica cargos del empleado

                // TODO: Hacer la parte de modificar los cargos

                // $camposCargos = Carrec::all(); //["director","tecnic_sala","ajustador","actor","traductor","linguista"];
                // $idiomas = Idioma::all(); //["Català", 'Castellà', "Anglès"];

                // $datos = [];

                // foreach ($camposCargos as $key => $carrec) {
                //     $id_carrec = $carrec->id_carrec;
                //     $nomCarrec = $carrec->input_name;
                    
                //     if (($nomCarrec == "director" || $nomCarrec == "tecnic_sala" || $nomCarrec == "ajustador") && request()->has($nomCarrec)) {
                //         $datos["id_empleat"] = $id;
                //         $datos["id_carrec"] = $id_carrec;
                //         $datos["id_idioma"] = 0;
                //         $datos["empleat_homologat"] = false;
                //         $datos["preu_carrec"] = (request()->has("preu_$nomCarrec")) ? request()->input("preu_$nomCarrec") : 0;

                //         $carrecAntic = CarrecEmpleat::where([
                //             ['id_empleat', '=', $id],
                //             ['id_carrec', '=', $id_carrec],
                //             ['id_idioma', '=', '0']
                //         ])->first();
                //         // return response()->json($carrecAntic);

                //         $carrecAntic->fill($datos);
                //         $carrecAntic->save();
                //         // $carrecEmpleat = new CarrecEmpleat($datos);
                //         // // TODO: Validar "carrecEmpleat"
                //         // $carrecEmpleat->save();
                //     } else if (request()->has($nomCarrec)) {
                //         // foreach ($idiomas as $key => $idioma) {
                //         //     $id_idioma = $idioma->id_idioma;
                //         //     $nom_idioma = $idioma->idioma;

                //         //     if (request()->has("idioma_$nomCarrec" . "_$nom_idioma")) {
                //         //         $datos["id_empleat"] = $empleat->id_empleat;
                //         //         $datos["id_carrec"] = $id_carrec;
                //         //         $datos["id_idioma"] = $id_idioma;
                //         //         $datos["empleat_homologat"] = (request()->has("homologat_$nomCarrec" . "_$nom_idioma")) ? request()->input("homologat_$nomCarrec" . "_$nom_idioma") : false;
                //         //         $datos["preu_carrec"] = (request()->has("preu_$nomCarrec" . "_$nom_idioma")) ? request()->input("preu_$nomCarrec" . "_$nom_idioma") : 0;
    
                //         //         $carrecEmpleat = new CarrecEmpleat($datos);
                //         //         // TODO: Validar "carrecEmpleat"
                //         //         $carrecEmpleat->save();
                //         //     }
                //         // }
                //     }
                // }

                return $this->index();
            }
        }
    }

    public function delete(Request $request)
    {
        CarrecEmpleat::where('id_empleat', $request["id"])->delete();
        EmpleatExtern::where('id_empleat', $request["id"])->delete();
        return $this->index();
    }
}
