<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\EmpleatExtern;

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
        return View('empleats_externs.show', array('empleat' => $empleat));
    }

    public function insertView() {
        return View('empleats_externs.create');
    }

    public function updateView($id) {
        // TODO: Controlar si l'empleat existeix o no per mostrar una página o un altre
        $empleat = EmpleatExtern::find($id);
        return View('empleats_externs.create', array('empleat' => $empleat));
    }

    public function insert() {
        $empleat = new EmpleatExtern(request()->all());

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
            $usuario->save();
            return $this->viewRegistre();
        }
    }

    public function update() {

    }

    public function delete(Request $request) {
        User::where('id_empleat',$request["id"])->delete();
        return $this->index();
    }
}
