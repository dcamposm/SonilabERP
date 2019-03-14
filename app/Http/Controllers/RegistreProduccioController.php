<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistreProduccioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        $registresProduccio = array('3838','001','29/09/2018','1','SHANE - THE DISTANT BELL');
        return View('registre_produccio.index', array('registreProduccio' => $registresProduccio));
    }

}
