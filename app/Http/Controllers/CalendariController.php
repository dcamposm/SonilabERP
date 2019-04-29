<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Validator;
use DateTime;

class CalendariController extends Controller
{
    public function showCalendari($year = null, $week = null){

        $fecha = Carbon::now();
        if ($week == null || $year == null){
            $week = $fecha->weekOfYear;
            $year = $fecha->year;
        } else {
            $fecha->setISODate($year, $week);
        }
        $dia1 = $fecha->startOfWeek();
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

        $urlBase = route('showCalendari');

        $actores = [];

        return View('calendari.index', ["fechas" => $fechas, "week" => $week, "year" => $year, "urlBase" => $urlBase, "actores" => $actores]);
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
