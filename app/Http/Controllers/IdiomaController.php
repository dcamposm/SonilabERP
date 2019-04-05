<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Idioma;
use Validator;

class IdiomaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() //Retorna tots els idiomes de la BBDD
    {
        $idiomes = Idioma::all();
        return View('idiomes.index', array('idiomes' => $idiomes));
    }
    
    public function insertView(){ //Retorna el formulari per crear un idioma
        return View('idiomes.create');
    }
    
    function insert(){ //Inserta un nou idioma a la BBDD
        
        $idioma = new Idioma();
        $idioma->idioma = request()->input('idioma');
        
        $v = Validator::make(request()->all(), [
            'idioma' => 'required',
        ]);
        
        if ($v->fails()){
            return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'han introduit totes les dades'));
            //return response()->json(["error" => true], 400);
        } else {            
            if ($_FILES["img_idioma"]["tmp_name"]!=""){
            }
            try{
                $idioma->save();
            } catch (\Exception $e){
                return redirect()->back()->withErrors(array('error' => 'ERROR. No s\'ha pogut crear el idioma.'));
            }
            return redirect()->back()->with('success', 'S\'ha creat el idioma correctament');
        }
    }
    
    public function delete(Request $request) { //Funcio per esborrar un idioma
        Idioma::where('id_idioma', $request["id"])->delete();
        return redirect()->route('indexIdioma');
    }
}
