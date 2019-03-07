<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Departament;

class ProjectesController extends Controller
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

    function viewProjectes(){
        $projectes = Projecte::all();
        return view("registre_produccio",array('projectes' => $projectes));
    }

    function getIndex(){
        $projectes= User::all();
        return view('projectes.index',array('arrayProjectes' => $projectes));
    }
}
