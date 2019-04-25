<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CalendariController extends Controller
{
    public function showCalendari($semana = null){

        $now = Carbon::now();
        $numSemana = $now->weekOfYear;
        $dia1 = $now->startOfWeek();
        $dia2 = $dia1->copy()->addDay();
        $dia3 = $dia2->copy()->addDay();
        $dia4 = $dia3->copy()->addDay();
        $dia5 = $dia4->copy()->addDay();
        $fechas = [
            $dia1->format('d-m-Y'), 
            $dia2->format('d-m-Y'), 
            $dia3->format('d-m-Y'), 
            $dia4->format('d-m-Y'), 
            $dia5->format('d-m-Y')
        ];
        return View('calendari.index', ["fechas" => $fechas, "numSemana" => $numSemana]);
    }
}
