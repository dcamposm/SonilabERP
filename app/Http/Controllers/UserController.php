<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Departament;

class UserController extends Controller
{
    function viewRegistre(){
        $departaments = Departament::all();
        return view("usuaris_interns.create",array('departaments' => $departaments));
    }

    function viewEditarUsuario($id){
        //ToDo: Retornar vista
        return "Se editará $id";
    }


    function getIndex(){
        $usuaris= User::all();
        return view('usuaris_interns.index',array('arrayUsuaris' => $usuaris));
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
        
        //ToDo: FALTA COMPLETAR VALIDATOR
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
            $usuario->fill(request()->all());
            $usuario->save();
        }
    }

    /*
    *funcio per retornar la vista de crear usuaris interns
   */
    
    /**
     * Esborra l'usuari especificat.
     * 
     * @return void
     */
    function esborrarUsuari($id_usuari) {
        User::where('id_usuari',$id_usuari)->delete();
    }
}
