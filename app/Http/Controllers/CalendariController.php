<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Validator;
use App\{Calendar, CalendarCarrec, Missatge, User, EmpleatExtern, ActorEstadillo, Estadillo, Carrec, RegistreProduccio, RegistreEntrada};
use DateTime;
use DB;
use App\Http\Requests\{CalendariCreateRequest, CalendariUpdateRequest, CalendariCarrecCreateRequest, CalendariCarrecUpdateRequest};

class CalendariController extends Controller
{
    public function showCalendari($year = null, $week = null){
        $meses = array("Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Decembre");
        $fecha = Carbon::now();
        //return response()->json($fecha->month);
        if ($week == null || $year == null){
            $week = $fecha->weekOfYear;
            $year = $fecha->year;
            $mes = $meses[($fecha->format('n')) - 1];
        } else {
            $fecha->setISODate($year, $week);
            $mes = $meses[($fecha->format('n')) - 1];
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

        $data = Calendar::where('data_inici', '>=', $dia1)
                                    ->where('data_fi', '<=', $dia5)
                                    ->with('actor.estadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actor')
                                    ->with('calendari')
                                    ->with('registreEntrada')
                                    ->with('director')
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();

        $urlBase = route('showCalendari');
        
        $actores = CalendariController::getActors();

        $tecnics = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                  ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                  ->join('slb_carrecs', 'slb_carrecs.id_carrec', 'slb_carrecs_empleats.id_carrec')
                                  ->distinct()->where('slb_carrecs.nom_carrec', 'Tècnic de sala')
                                  ->get();
        
        // TODO: Hacer que los actores no se repitan o que si se repiten que se coja también la hora.
        $actoresPorDia = CalendariController::getActorsPerDia($fechas);

        $tecnicsAsignados = CalendarCarrec::where('data', '>=', $dia1)->where('data', '<=', $dia5)->with('empleat')->get();
        $directors = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                        ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                        ->distinct()->where('slb_carrecs.nom_carrec', '=', 'Director')
                                        ->get();
        
        $festius = CalendarCarrec::where('data', '>=', $dia1)->where('data', '<=', $dia5)->whereFestiu(1)->get();
        
        return View('calendari.index', ["fechas"    => $fechas, 
                                        "week"      => $week,
                                        "year"      => $year,
                                        "mes"       => $mes,
                                        "urlBase"   => $urlBase,
                                        "actores"   => $actores,
                                        "tecnics"   => $tecnics,
                                        "directors"   => $directors,
                                        "data"      => $data,
                                        "actoresPorDia" => $actoresPorDia,
                                        "tecnicsAsignados" => $tecnicsAsignados,
                                        "festius"   => $festius
        ]);
    }

    public function cambiarCargo(Request $request) {
        // Coge todos los parámetros necesarios:
        $data       = strtotime($request->get('data'));
        $data       = date('Y-m-d H:i:s', $data);
        $sala       = $request->get('sala');
        $id_empleat = $request->get('id_empleat');
        $torn       = $request->get('torn');

        // Comprueba si ya existe un registro en la base de datos:
        if ($id_empleat != 0) {
            $calendariCarrec = CalendarCarrec::whereData($data)
                                           ->whereTorn($torn)
                                           ->whereIdEmpleat($id_empleat)
                                           ->first();
            
            if ($calendariCarrec) {
                return response()->json(['success'=> false,"r"=>1,"torn"=>$torn],400);
            }
        }
        $calendariCarrec = CalendarCarrec::whereData($data)
                                           ->whereTorn($torn)
                                           ->whereNumSala($sala)
                                           ->first();
        
        if (!$calendariCarrec) $calendariCarrec = new CalendarCarrec;
        
        // Asignamos los valores al objeto:
        $calendariCarrec->data          = $data;
        $calendariCarrec->num_sala      = $sala;
        $calendariCarrec->id_empleat    = $id_empleat;
        $calendariCarrec->torn          = $torn;
        // Guardamos el objeto en la base de datos:
        $calendariCarrec->save();
        
        $calendariCarrec->empleat;
        // Retornamos el resultado para indicar que todo ha ido OK:
        return response()->json($calendariCarrec);
    }

    public function desarLlistaAsistencia() {
        // Coge la petición y la recorre:
        $datos = request()->all();
        foreach ($datos as $key => $dato) {
            // Coge el identificador del calendario (el valor de key es: actor-idEmpleado-idCalendar):
            $id_calendar = explode('-', $key)[2];

            // Coge el calendario en cuestión de la base de datos y modifica la asistencia:
            $calendario = Calendar::find($id_calendar);
            if ($dato == "null") {
                $calendario->asistencia = null;
            }
            else {
                $calendario->asistencia = intval($dato);
            }

            // Aplica los nuevos cambios del calendario en la base de datos:
            $calendario->save();
        }
        $calendario = Calendar::all();
        // Retorna una respuesta:
        return response()->json($calendario);
    }

    public function create(CalendariCreateRequest $request){
        $request['data_inici'] = Carbon::createFromFormat('d-m-Y H:i:s', request()->input('data_inici'));
        
        if (!$request['data_fi']) {
            if (request()->input('num_takes') <= 10){
                $data_fi = strtotime ( '+30 minute', strtotime ($request['data_inici']));
            } else {
                $min = (int)request()->input('num_takes')*3;
                $data_fi = strtotime ( '+'.$min.' minute', strtotime ($request['data_inici']));
            }

            $request['data_fi'] = date('d-m-Y H:i:s', $data_fi);
        }
        
        
        if (strtotime($request['data_inici']) < strtotime( $request['data_inici']->format('Y-m-d')." 13:30:01")){
            $torn = 0;
        } else {
            $torn = 1;
        }

        $calendariCarrec = CalendarCarrec::where('num_sala', $request['num_sala'])
                                            ->where('data', $request['data_inici']->format('Y-m-d'))
                                            ->where('torn', $torn)->first();
        
        if (!$calendariCarrec){
            $calendariCarrec = new CalendarCarrec($request);
            $calendariCarrec->data = $request['data_inici']->format('Y-m-d');
            $calendariCarrec->torn = $torn;

            $calendariCarrec->save();
        }
        if (!request()->input('id_director')) {
            $produccio = RegistreProduccio::where('id_registre_entrada', $request['id_registre_entrada'])
                                        ->where('setmana', $request['setmana'])
                                        ->whereNotNull('id_director')->first();
        }
        
        //return response()->json(['success'=> true, $request->input()],201);
        $calendari = new Calendar($request->input());  
        $calendari->id_calendar_carrec = $calendariCarrec->id_calendar_carrec;
        $calendari->id_director = !request()->input('id_director') ? $produccio->id_director : ($request['id_director'] == -1 ? 0 : $request['id_director']);
        $calendari->data_fi  = Carbon::createFromFormat('d-m-Y H:i:s', $request['data_fi']);
        $calendari->save();
        
        $calendari = Calendar::where('id_calendar', $calendari->id_calendar )
                                    ->with('actor.estadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actor')
                                    ->with('calendari')
                                    ->with('director')
                                    ->first();
        
        return response()->json(['success'=> true,'calendari'=>$calendari],201);
    }

    public function update(CalendariUpdateRequest $request, $id){
        $calendari = Calendar::findOrFail($id);
        // NOTE: Hay que hacer que el data_inici y el date_fi se le asigne las horas y los minutos que le lleguen
        //       del frontend.
        $data_inici = explode(" ",$calendari->data_inici)[0].' '.request()->input('data_inici').':00';
        $data_fi = explode(" ", $calendari->data_fi)[0].' '.request()->input('data_fi').':00';
        $valores = array(
            'id_actor'               => request()->get('id_actor'),
            'id_registre_entrada'    => request()->get('id_registre_entrada'),
            'setmana'                => request()->get('setmana'),
            'num_takes'              => request()->get('num_takes'),
            'data_inici'             => $data_inici,
            'data_fi'                => $data_fi,
            'opcio_calendar'         => request()->get('opcio_calendar'),
            'num_sala'               => request()->get('num_sala'),
            'id_director'            =>request()->get('id_director'),
        );
        
        if (strtotime($valores['data_inici']) < strtotime( date('Y-m-d', strtotime($valores['data_inici']))." 13:30:01")){
            $torn = 0;
        } else {
            $torn = 1;
        }

        $calendariCarrec = CalendarCarrec::where('num_sala', $valores['num_sala'])
                                            ->where('data', date('Y-m-d', strtotime($valores['data_inici'])))
                                            ->where('torn', $torn)->first();

        if (!$calendariCarrec){
            $calendariCarrec = new CalendarCarrec($valores);
            $calendariCarrec->data = date('Y-m-d',strtotime($valores['data_inici']));
            $calendariCarrec->torn = $torn;

            $calendariCarrec->save();
        }

        // Datos correctos.
        $calendari->fill($valores);  
        $calendari->id_calendar_carrec = $calendariCarrec->id_calendar_carrec;
        $calendari->save();
        
        $users = User::where('id_departament', 4)->get();
        foreach ($users as $user){
            $missatge = new Missatge();
            $missatge->missatgeCalendariUpdate($calendari, $user->id_usuari); 
            $missatge->save(); 
        }
         
        $calendari = Calendar::where('id_calendar', $calendari->id_calendar )
                                    ->with('actor.estadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actor')
                                    ->with('calendari')
                                    ->with('director')
                                    ->first();
        
        return response()->json($calendari);
    }

    public function delete($id){
        $calendari = Calendar::findOrFail($id);
        $calendari->delete();
       
        return response()->json("Esborrat Ok!");
    }
    
    
    public function calendariCarrecInsertar(CalendariCarrecCreateRequest $request){
        $calendariCarrec = new CalendarCarrec(request()->all());  
        $calendariCarrec->save();

        return redirect()->route('showCalendari');
    }
    
    public function calendariCarrecEditar(CalendariCarrecUpdateRequest $request, $id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        // Datos correctos.
        $calendariCarrec->fill(request()->all());  
        $calendariCarrec->save();

        return response()->json(request()->all());
    }

    public function calendariCarrecDelete($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $calendariCarrec->delete();
       
        return redirect()->route('showCalendari');
    }

    public function cogerCalendarioActor() {
        $calendar = Calendar::with('actor.estadillo.estadillo.registreProduccio')
                ->with('calendari')
                ->with('director')
                ->find(request()->get('id'));

        return response()->json(array(
            'calendar'  => $calendar
        ));
    }

    public function getPeliculas() {
        $peliculas = RegistreProduccio::all();
        
        return $peliculas;
    }
    
    public function postActors() {
        $actores = CalendariController::getActors();
        
        return response()->json($actores);
    }
    
    public function getActors() {
        $takes_restantes = ActorEstadillo::select('slb_actors_estadillo.id_actor',
                                                    DB::raw('SUM(slb_actors_estadillo.take_estadillo) as takes_restantes'),
                                                    'slb_registres_produccio.id_registre_entrada',
                                                    'slb_registres_produccio.setmana')
                                            ->join('slb_empleats_externs', 'slb_empleats_externs.id_empleat', 'slb_actors_estadillo.id_actor')
                                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                                            ->join('slb_registre_entrades', 'slb_registre_entrades.id_registre_entrada', 'slb_registres_produccio.id_registre_entrada')
                                            ->groupBy('slb_actors_estadillo.id_actor','slb_registres_produccio.id_registre_entrada', 'slb_registres_produccio.setmana')
                                            ->where('slb_registres_produccio.estat', 'Pendent')
                                            ->with('empleat.actorCalendar')->get();                          

        $calendaris = Calendar::all();
        foreach ($takes_restantes as $key => $value) {
            $entrada = RegistreEntrada::with('registreProduccio')->find($value->id_registre_entrada);

            $value->nombre_reg_complet = $entrada->getReferenciaTitolPack($value->setmana);

            if ( isset($value->empleat->actorCalendar[0])){
                foreach($calendaris as $calendar) {
                    if ($value->id_actor == $calendar->id_actor && $value->id_registre_entrada == $calendar->id_registre_entrada && $value->setmana == $calendar->setmana){
                        $value->takes_restantes = $value->takes_restantes - $calendar->num_takes;
                    }
                }
            } 
        }
        
        $actores = $takes_restantes;

        return $actores;
    }
    
    public function postDades() {
        $fecha = Carbon::now();
        $fecha->setISODate(request()->get('year'), request()->get('week'));

        $dia1 = $fecha->startOfWeek();
        $dia2 = $dia1->copy()->addDay();
        $dia3 = $dia2->copy()->addDay();
        $dia4 = $dia3->copy()->addDay();
        $dia5 = $dia4->copy()->addDay()->addHours(23)->addMinutes(59);
        
        $data = Calendar::where('data_inici', '>=', $dia1)
                                    ->where('data_fi', '<=', $dia5)
                                    ->with('actor.estadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actor')
                                    ->with('calendari')
                                    ->with('registreEntrada')
                                    ->with('director')
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();
        
        return response()->json($data);
    }
    
    public function actorsPerDia() {
        $actoresPorDia = CalendariController::getActorsPerDia(request()->get('fechas'));
        
        return response()->json($actoresPorDia);
    }
    
    public function getActorsPerDia($fechas) {
        $actoresPorDia = array();
        
        foreach($fechas as $key => $fech) {
            $diaz = DateTime::createFromFormat("d-m-Y", $fech);
            
            $act_dia = EmpleatExtern::select('slb_empleats_externs.id_empleat',
                                             'slb_empleats_externs.nom_empleat',
                                             'slb_empleats_externs.cognom1_empleat',
                                             'slb_empleats_externs.cognom2_empleat',
                                             'slb_calendars.id_calendar',
                                             'slb_calendars.id_registre_entrada',
                                             'slb_calendars.setmana',
                                             DB::raw('DAY(slb_calendars.data_inici) as dia'),
                                             'slb_calendar_carrecs.num_sala',
                                             DB::raw('LPAD(HOUR(slb_calendars.data_inici), 2, 0) as hora'),
                                             DB::raw('LPAD(MINUTE(slb_calendars.data_inici), 2, 0) as minuts'),
                                             'slb_calendars.asistencia',
                                             'slb_calendars.id_director')
                                    ->join('slb_calendars', 'slb_calendars.id_actor', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_calendar_carrecs', 'slb_calendar_carrecs.id_calendar_carrec', 'slb_calendars.id_calendar_carrec')
                                    ->distinct()->where( DB::raw('DAY(slb_calendars.data_inici)'), '=', $diaz->format('d'))
                                    ->where( DB::raw('MONTH(slb_calendars.data_inici)'), '=', $diaz->format('m'))
                                    ->where( DB::raw('YEAR(slb_calendars.data_inici)'), '=', $diaz->format('Y'))
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();       
            
            foreach ($act_dia as $key => $act) {
                if (isset($act['id_registre_entrada'])){

                    $entrada = RegistreEntrada::with('registreProduccio')->find($act['id_registre_entrada']);
                    $act->nombre_reg_complet = $entrada->getReferenciaTitolPack($act['setmana']);
                }
            }
            
            array_push($actoresPorDia, $act_dia);
        }
        
        
        //dd($actoresPorDia);
        return $actoresPorDia;
    }
    
    public function getDay(Request $request) {
        $d       = strtotime($request->get('day'));
        $fecha   = date('Y-m-d', $d);

        $data = Calendar::where(DB::raw('DATE(data_inici)'), $fecha)
                                    ->with('actor.estadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actor')
                                    ->with('calendari')
                                    ->with('registreEntrada')
                                    ->with('director')
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();
        
        $tecnics = CalendarCarrec::where('data', $fecha)->with('empleat')->get();
        
        return response()->json(["data" => $data, "tecnics" => $tecnics]);
    }
}
