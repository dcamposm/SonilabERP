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
        return View('empleats_externs.insert');
    }

    public function insert() {

    }

    public function updateView($id) {
        // TODO: Controlar si l'empleat existeix o no per mostrar una página o un altre
        $empleat = EmpleatExtern::find($id);
        return View('empleats_externs.show', array('empleat' => $empleat));
    }

    public function update() {

    }

    public function delete(Request $request) {
        User::where('id_empleat',$request["id"])->delete();
        return $this->index();
    }
}
