<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistreEntradaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index()
    {
        //$registreEntrada = RegistreEntrada::all();
        //return View('registre_entrada.index', array('registreEntrada' => $registreEntrada));
        return View('registre_entrada.index');
       
    }
}
