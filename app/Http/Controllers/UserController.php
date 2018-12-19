<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
    function viewEditarUsuario($id){
        //ToDo: Retornar vista
        return "Se editará $id";
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
}
