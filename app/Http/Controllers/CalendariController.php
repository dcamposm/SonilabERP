<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendariController extends Controller
{
    public function showCalendari(){
        return View('calendari.index');
    }
}
