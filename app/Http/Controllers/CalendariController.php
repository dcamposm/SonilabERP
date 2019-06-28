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

        $data = json_encode(Calendar::where('data_inici', '>=', $dia1)
                                    ->where('data_fi', '<=', $dia5)
                                    ->with('actorEstadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('actorEstadillo.empleat')
                                    ->with('calendari')
                                    ->with('director')
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get());
        
        $urlBase = route('showCalendari');

        $takes_restantes = ActorEstadillo::select('slb_actors_estadillo.id as id_actor_estadillo',
                                                    'slb_actors_estadillo.id',
                                                    'slb_actors_estadillo.take_estadillo as takes_restantes',
                                                    'slb_actors_estadillo.id_actor',
                                                    'slb_actors_estadillo.id_produccio',
                                                    'slb_actors_estadillo.narracio_estadillo',
                                                    'slb_actors_estadillo.canso_estadillo',
                                                    'slb_estadillo.id_registre_produccio')
                                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', 'slb_actors_estadillo.id_produccio')
                                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', 'slb_estadillo.id_registre_produccio')
                                            ->distinct()->where('slb_registres_produccio.estat', 'Pendent')
                                            ->with('calendar')->get();                          
        
        foreach ($takes_restantes as $key => $value) {
            if ($value->estadillo != null) {
                if ($value->estadillo->registreProduccio != null){
                    $empleado = EmpleatExtern::findOrFail($value->id_actor);
                    $produccio = RegistreProduccio::findOrFail($value->id_registre_produccio);
                    $entrada = RegistreEntrada::findOrFail($produccio->id_registre_entrada);
                    $value->nombre_actor = $empleado->nom_cognom;
                    $value->nombre_reg_entrada = $entrada->referencia_titol;
                    $value->nombre_reg_produccio = $produccio->subreferencia != 0 ? $produccio->subreferencia : '';
                    $value->nombre_reg_complet = $value->nombre_reg_entrada.' '.$value->nombre_reg_produccio;
                    if ( isset($value->calendar[0]) ){
                        foreach($value->calendar as $calendar) {
                            $value->takes_restantes = $value->takes_restantes - $calendar->num_takes;
                            if ($value->canso_estadillo == $calendar->canso_calendar){
                                $value->canso_estadillo = 0;
                            }
                            if ($value->narracio_estadillo == $calendar->narracio_calendar) {
                                $value->narracio_estadillo = 0;
                            }  
                        }
                    } 
                } else {
                    unset($takes_restantes[$key]);
                }
                
            } else {
                unset($takes_restantes[$key]);
            }
        }

        $actores = json_encode($takes_restantes);

        $tecnics = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                  ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', 'slb_empleats_externs.id_empleat')
                                  ->join('slb_carrecs', 'slb_carrecs.id_carrec', 'slb_carrecs_empleats.id_carrec')
                                  ->distinct()->where('slb_carrecs.nom_carrec', 'Tècnic de sala')
                                  ->get();
        
        // TODO: Hacer que los actores no se repitan o que si se repiten que se coja también la hora.
        $actoresPorDia = array();
        foreach($fechas as $key => $fech) {
            $diaz = DateTime::createFromFormat("d-m-Y", $fech);
            
            $act_dia = EmpleatExtern::select('slb_empleats_externs.id_empleat',
                                             'slb_empleats_externs.nom_empleat',
                                             'slb_empleats_externs.cognom1_empleat',
                                             'slb_empleats_externs.cognom2_empleat',
                                             'slb_calendars.id_calendar',
                                             DB::raw('DAY(slb_calendars.data_inici) as dia'),
                                             'slb_calendar_carrecs.num_sala',
                                             DB::raw('LPAD(HOUR(slb_calendars.data_inici), 2, 0) as hora'),
                                             DB::raw('LPAD(MINUTE(slb_calendars.data_inici), 2, 0) as minuts'),
                                             'slb_actors_estadillo.id as id_actor_estadillo',
                                             'slb_calendars.id_calendar as id_calendar',
                                             'slb_calendars.asistencia',
                                             'slb_calendars.id_director')
                                    ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_calendars', 'slb_calendars.id_actor_estadillo', 'slb_actors_estadillo.id')
                                    ->join('slb_calendar_carrecs', 'slb_calendar_carrecs.id_calendar_carrec', 'slb_calendars.id_calendar_carrec')
                                    ->distinct()->where( DB::raw('DAY(slb_calendars.data_inici)'), '=', $diaz->format('d'))
                                    ->where( DB::raw('MONTH(slb_calendars.data_inici)'), '=', $diaz->format('m'))
                                    ->where( DB::raw('YEAR(slb_calendars.data_inici)'), '=', $diaz->format('Y'))
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();       
                    
            array_push($actoresPorDia, $act_dia);
        }

        $tecnicsAsignados = CalendarCarrec::where('data', '>=', $dia1)->where('data', '<=', $dia5)->with('empleat')->get();
        $directors = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'nom_empleat', 'cognom1_empleat', 'cognom2_empleat')
                                        ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                        ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                        ->distinct()->where('slb_carrecs.nom_carrec', '=', 'Director')
                                        ->get();

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
                                        "tecnicsAsignados" => $tecnicsAsignados]);
    }

    public function cambiarCargo(Request $request) {
        // Coge todos los parámetros necesarios:
        $data       = strtotime($request->get('data'));
        $data       = date('Y-m-d H:i:s', $data);
        $sala       = $request->get('sala');
        $id_empleat = $request->get('id_empleat');
        $torn       = $request->get('torn');
        $color      = $request->get('color_empleat');

        // Comprueba si ya existe un registro en la base de datos:
        $calendariCarrec = CalendarCarrec::where('data', '=', $data)
                                           ->where('torn', '=', $torn)
                                           ->first();
        if (!$calendariCarrec) {
            // Si no existe entonces creamos el objeto.
            $calendariCarrec = new CalendarCarrec;
        }

        // Asignamos los valores al objeto:
        $calendariCarrec->data          = $data;
        $calendariCarrec->num_sala      = $sala;
        $calendariCarrec->id_empleat    = $id_empleat;
        $calendariCarrec->torn          = $torn;
        $calendariCarrec->color_empleat = $color;
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
        // Datos correctos.
        $requestData = request()->all();

        $requestData['data_inici'] = Carbon::createFromFormat('d-m-Y H:i:s', request()->input('data_inici'));
        $requestData['data_fi'] = Carbon::createFromFormat('d-m-Y H:i:s', request()->input('data_fi'));

        if (strtotime($requestData['data_inici']) < strtotime( $requestData['data_inici']->format('Y-m-d')." 13:30:01")){
            $torn = 0;
        } else {
            $torn = 1;
        }

        $calendariCarrec = CalendarCarrec::where('num_sala', $requestData['num_sala'])
                                            ->where('data', $requestData['data_inici']->format('Y-m-d'))
                                            ->where('torn', $torn)->first();

        if (!$calendariCarrec){
            $calendariCarrec = new CalendarCarrec($requestData);
            $calendariCarrec->data = $requestData['data_inici']->format('Y-m-d');
            $calendariCarrec->torn = $torn;

            $calendariCarrec->save();
        }

        $actorEstadillo = ActorEstadillo::find($requestData['id_actor_estadillo']);

        $calendari = new Calendar($requestData);  
        $calendari->id_calendar_carrec = $calendariCarrec->id_calendar_carrec;
        $calendari->id_director = $actorEstadillo->estadillo->registreProduccio->id_director;

        $calendari->save();
        $calendari->calendari;
        $calendari->actorEstadillo->estadillo->registreProduccio->registreEntrada;
        $calendari->actorEstadillo->empleat;
        $calendari->director;
        
        return response()->json(['success'=> true,'calendari'=>$calendari],201);
    }

    public function update(CalendariUpdateRequest $request, $id){
        $calendari = Calendar::findOrFail($id);
        // NOTE: Hay que hacer que el data_inici y el date_fi se le asigne las horas y los minutos que le lleguen
        //       del frontend.
        $data_inici = explode(" ",$calendari->data_inici)[0].' '.request()->input('data_inici').':00';
        $data_fi = explode(" ", $calendari->data_fi)[0].' '.request()->input('data_fi').':00';
        $valores = array(
            'id_actor_estadillo' => request()->get('id_actor_estadillo'),
            'num_takes'          => request()->get('num_takes'),
            'data_inici'         => $data_inici,
            'data_fi'            => $data_fi,
            'num_sala'           => request()->get('num_sala'),
            'canso_calendar'     => request()->get('canso_calendar'),
            'narracio_calendar'     => request()->get('narracio_calendar'),
            'id_director'        =>request()->get('id_director'),
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
            $calendariCarrec = new CalendarCarrec($requestData);
            $calendariCarrec->data = $requestData['data_inici']->format('Y-m-d');
            $calendariCarrec->torn = $torn;

            $calendariCarrec->save();
        }

        $actorEstadillo = ActorEstadillo::find($valores['id_actor_estadillo']);
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
         
        $calendari->calendari;
        $calendari->actorEstadillo->estadillo->registreProduccio->registreEntrada;
        $calendari->actorEstadillo->empleat;
        $calendari->director;
        
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
        $calendar = Calendar::with('actorEstadillo.estadillo.registreProduccio')
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
}
