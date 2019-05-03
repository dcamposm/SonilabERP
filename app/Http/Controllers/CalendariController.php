<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Validator;
use App\Calendar;
use App\CalendarCarrec;
use DateTime;
use App\EmpleatExtern;

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
        $dia5 = $dia4->copy()->addDay()->addHours(23)->addMinutes(59);
        $fechas = [
            $dia1->format('d-m-Y'), 
            $dia2->format('d-m-Y'), 
            $dia3->format('d-m-Y'), 
            $dia4->format('d-m-Y'), 
            $dia5->format('d-m-Y')
        ];

        $data = json_encode(Calendar::where('data_inici', '>=', $dia1)
                        ->where('data_fi', '<=', $dia5)
                        ->get());
        
        $urlBase = route('showCalendari');

        $actores = [];
        $tecnics = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                  ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                  ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                  ->where('slb_carrecs.nom_carrec', '=', 'Tècnic de sala')
                                  ->get();
        $directors = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                    ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                    ->where('slb_carrecs.nom_carrec', '=', 'Director')
                                    ->get();
        
        // TODO: Quitar esto cuando se terminen las pruebas:
        $data = '[{"data_inici":"02-05-2019 00:45:00","data_fi":"02-05-2019 18:15:00","empleat":"Dumbo","num_takes":"100","num_sala":1},{"data_inici":"03-05-2019 00:45:00","data_fi":"03-05-2019 10:15:00","empleat":"Peponcio","num_takes":"69","num_sala":7},{"data_inici":"01-05-2019 05:45:00","data_fi":"01-05-2019 20:15:00","empleat":"Dumbo","num_takes":"1","num_sala":4},{"data_inici":"06-05-2019 08:45:00","data_fi":"06-05-2019 10:20:00","empleat":"Dorita","num_takes":"20","num_sala":6},{"data_inici":"06-05-2019 10:30:00","data_fi":"06-05-2019 14:14:51","empleat":"Dorito","num_takes":"43","num_sala":6}]';

        return View('calendari.index', ["fechas"    => $fechas, 
                                        "week"      => $week,
                                        "year"      => $year,
                                        "urlBase"   => $urlBase,
                                        "actores"   => $actores,
                                        "tecnics"   => $tecnics,
                                        "directors" => $directors,
                                        "data"      => $data]);
    }

    public function getDay(Request $request) {
        return response()->json(request()->all());
    }

    public function create(){
        $v = Validator::make(request()->all(),[
            //'id_calendar'=>'required|max:35',
            'id_empleat'=>'required|max:35',
            'id_registre_entrada'=>'required|max:35',
            'num_takes'=>'required|regex:/^[0-9]+$/',//^[0-9]+$
            'data_inici'=>'required|max:35',
            'data_fi'=>'required|max:35',
            'num_sala'=>'required|max:35'
        ]);

        if ($v->fails()) {
            // Datos incorrectos.
            return redirect()->back()->withErrors($v)->withInput();
        }
        else {
            //return response()->json(request()->all());
            // Datos correctos.
            $calendari = new Calendar(request()->all());  
            $calendari->save();

            return redirect()->route('showCalendari');
        }
    }

    public function update($id){
        $calendari = Calendar::findOrFail($id);

        $v = Validator::make(request()->all(),[
            //'id_calendar'=>'required|max:35',
            'id_empleat'=>'required|max:35',
            'id_registre_entrada'=>'required|max:35',
            'num_takes'=>'required|regex:/^[0-9]+$/',//^[0-9]+$
            'data_inici'=>'required|max:35',
            'data_fi'=>'required|max:35',
            'num_sala'=>'required|max:35'
        ]);

        if ($v->fails()) {
            // Datos incorrectos.
            return redirect()->back()->withErrors($v)->withInput();
        }
        else {
            //return response()->json(request()->all());
            // Datos correctos.
            $calendari->fill(request()->all());  
            $calendari->save();

            return redirect()->route('showCalendari');
        }
    }

    public function delete($id){
        $calendari = Calendar::findOrFail($id);
        $calendari->delete();
       
        return redirect()->route('showCalendari');
    }
    
    
    public function calendariCarrecInsertar(){
        $v = Validator::make(request()->all(),[
            //'id_calendar'=>'required|max:35',
            'id_carrec'=>'required|max:35|exists:slb_carrecs',
            'id_empleat'=>'required|max:35|exists:slb_empleats_externs',
            'num_sala'=>'required|regex:/^[0-9]+$/',//^[0-9]+$
            'data'=>'required|max:35',
            'torn'=>'required|max:3',
        ]);

        if ($v->fails()) {
            // Datos incorrectos.
            
            return redirect()->back()->withErrors($v)->withInput();
        }
        else {
            $calendariCarrec = new CalendarCarrec(request()->all());  
            $calendariCarrec->save();
            //return response()->json(request()->all());

            return redirect()->route('showCalendari');
        }
    }
    
    public function calendariCarrecEditar($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $v = Validator::make(request()->all(),[
            'id_carrec'=>'required|max:35|exists:slb_carrecs',
            'id_empleat'=>'required|max:35|exists:slb_empleats_externs',
            'num_sala'=>'required|regex:/^[0-9]+$/',
            'data'=>'required|max:35',
            'torn'=>'required|max:3',
        ]);
        
        if ($v->fails()) {
            // Datos incorrectos.
            return redirect()->back()->withErrors($v)->withInput();
        }
        else {
            //return response()->json(request()->all());
            // Datos correctos.
            $calendariCarrec->fill(request()->all());  
            $calendariCarrec->save();

            return response()->json(request()->all());
        }
    }

    public function calendariCarrecdelete($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $calendariCarrec->delete();
       
        return redirect()->route('showCalendari');
    }
}
