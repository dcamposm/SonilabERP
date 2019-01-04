<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Departament;

class UserController extends Controller
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

    /*
        *funcio per retornar la vista de crear usuaris interns
    */
    function viewRegistre(){
        $departaments = Departament::all();
        return view("usuaris_interns.create",array('departaments' => $departaments));
    }

    function viewEditarUsuario($id){
        $departaments = Departament::all();
        $usuario = User::find($id);
        if ($usuario){
            return view("usuaris_interns.create",array('departaments' => $departaments, 'usuario' => $usuario));
        }      
    }

    function getIndex(){
        $usuaris= User::all();
        return view('usuaris_interns.index',array('arrayUsuaris' => $usuaris));
    }
    
    function getShow($id){
         $usuaris= User::find($id);
         return view('usuaris_interns.show', array('arrayUsuaris' => $usuaris));
    }

    function crearUsuario(){
        
        $usuario = new User(request()->all());

        $v = Validator::make(request()->all(), [
            'nom_usuari' => 'required',
            'cognoms_usuari' => 'required',
            'email_usuari' => 'required',
            'alias_usuari' => 'required',
            'contrasenya_usuari' => 'required',
            'id_departament' => 'required'
        ]);

        if ($v->fails()){
            return response()->json(["error" => true], 400);
        } else {
            $usuario->save();
        }
    }

    function editarUsuario($id){
        $usuario = User::find($id);
        
        if ($usuario){
            //ToDo: FALTA COMPLETAR VALIDATOR
            $v = Validator::make(request()->all(), [
                'nom_usuari' => 'required',
                'cognoms_usuari' => 'required',
                'email_usuari' => 'required',
                'alias_usuari' => 'required',
                //'contrasenya_usuari' => 'required',
                'id_departament' => 'required'
            ]);

            if ($v->fails()){
                return response()->json(["error" => true], 400);
            } else {
                $usuario->fill(request()->all());
                $usuario->save();
                return $this->getIndex();
            }
        }
    }
    
    /**
     * Esborra l'usuari especificat.
     * 
     * @return void
     */
    function esborrarUsuari(Request $request) {
        User::where('id_usuari',$request["id"])->delete();
        return $this->getIndex();
    }
}
