<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CalendariController extends Controller
{
    public function showCalendari(){
        return View('calendari.index');
    }
    public function create(){
        $v = Validator::make(request()->all(),[
            'id_calendar'=>'required|max:35',
            'id_empleat'=>'required|max:35',
            'id_registre_entrada'=>'required|max:35',
            'num_takes'=>'required|regex:/[]/',
            'data_inici'=>'required|max:35',
            'data_fi'=>'required|max:35',
            'num_sala'=>'required|max:35'
        ]);
    }
}
