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
use App\ActorEstadillo;
use App\Estadillo;
use App\Carrec;
use DB;
use App\RegistreProduccio;
use App\RegistreEntrada;

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
                                    ->with('actorEstadillo.estadillo.registreProduccio.registreEntrada')
                                    ->with('calendari')
                                    ->get());

        //return response()->json($data);
        
        $urlBase = route('showCalendari');

        $takes_restantes = ActorEstadillo::select('slb_actors_estadillo.id as id_actor_estadillo',
                                                    'slb_actors_estadillo.id',
                                                    'slb_actors_estadillo.take_estadillo as takes_restantes',
                                                    'slb_actors_estadillo.id_actor',
                                                    'slb_actors_estadillo.id_produccio',
                                                    'slb_estadillo.id_registre_produccio')
                                            ->join('slb_estadillo', 'slb_estadillo.id_estadillo', '=', 'slb_actors_estadillo.id_produccio')
                                            ->join('slb_registres_produccio', 'slb_registres_produccio.id', '=', 'slb_estadillo.id_registre_produccio')
                                            ->distinct()->where('slb_registres_produccio.estat', '=', 'Pendent')
                                            ->get();                          
                  //$estadillo = \App\Estadillo::with('actors')->get();
        //return response()->json($takes_restantes);

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
                    if ($value->calendar != null){
                        $value->takes_restantes = $value->takes_restantes - $value->calendar->num_takes;
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
                                  ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                  ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                  ->distinct()->where('slb_carrecs.nom_carrec', '=', 'Tècnic de sala')
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
                                             'slb_calendars.id_calendar as id_calendar')
                                    ->join('slb_actors_estadillo', 'slb_actors_estadillo.id_actor', '=', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_calendars', 'slb_calendars.id_actor_estadillo', '=', 'slb_actors_estadillo.id')
                                    ->join('slb_calendar_carrecs', 'slb_calendar_carrecs.id_calendar_carrec', '=', 'slb_calendars.id_calendar_carrec')
                                    ->distinct()->where( DB::raw('DAY(slb_calendars.data_inici)'), '=', $diaz->format('d'))
                                    ->where( DB::raw('MONTH(slb_calendars.data_inici)'), '=', $diaz->format('m'))
                                    ->where( DB::raw('YEAR(slb_calendars.data_inici)'), '=', $diaz->format('Y'))
                                    ->orderBy('slb_calendars.data_inici')
                                    ->get();       
                    
            array_push($actoresPorDia, $act_dia);
        }
        //return response()->json($actoresPorDia);
        $tecnicsAsignados = CalendarCarrec::where('data', '>=', $dia1)->where('data', '<=', $dia5)->get();
        //return response()->json($tecnicsAsignados);
        return View('calendari.index', ["fechas"    => $fechas, 
                                        "week"      => $week,
                                        "year"      => $year,
                                        "urlBase"   => $urlBase,
                                        "actores"   => $actores,
                                        "tecnics"   => $tecnics,
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

        // Comprueba si ya existe un registro en la base de datos:
        $calendariCarrec = CalendarCarrec::where('data', '=', $data)
                                           ->where('torn', '=', $torn)
                                           ->first();
        if (empty($calendariCarrec) == true) {
            // Si no existe entonces creamos el objeto.
            $calendariCarrec = new CalendarCarrec;
        }

        // Asignamos los valores al objeto:
        $calendariCarrec->data       = $data;
        $calendariCarrec->num_sala   = $sala;
        $calendariCarrec->id_empleat = $id_empleat;
        $calendariCarrec->torn       = $torn;

        // Guardamos el objeto en la base de datos:
        $calendariCarrec->save();

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
            // return response()->json($calendario);

            // Aplica los nuevos cambios del calendario en la base de datos:
            $calendario->save();
        }

        // Retorna una respuesta:
        return response()->json("Tot Ok!");
    }

    public function create(){
        //return response()->json(request()->all());
        $v = Validator::make(request()->all(),[
            //'id_calendar'=>'required|max:35',
            'id_actor_estadillo'=>'required',
            'num_takes'=>'required|regex:/^[0-9]+$/',//^[0-9]+$
            'data_inici'=>'required',
            'data_fi'=>'required',
            'num_sala'=>'required'
        ]);

        if ($v->fails()) {
            // Datos incorrectos.
            return response()->json(['success'=> false,"iesse"=>$v->errors()],400);
        }
        else {
            //return response()->json(request()->all());
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
            return response()->json(['success'=> true,'calendari'=>$calendari],201);
        }
    }

    public function update($id){
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
            'num_sala'           => request()->get('num_sala')
        );
        //return response()->json($valores);

        $v = Validator::make($valores,[
            //'id_calendar'=>'required|max:35',
            'id_actor_estadillo' => 'required',
            'num_takes'          => 'required',
            'data_inici'         => 'required',
            'data_fi'            => 'required',
            'num_sala'           => 'required'
        ]);

        if ($v->fails()) {
            // Datos incorrectos.
            return redirect()->back()->withErrors($v)->withInput();
        }
        else {
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
            //return response()->json(request()->all());
            // Datos correctos.
            $calendari->fill($valores);  
            $calendari->id_calendar_carrec = $calendariCarrec->id_calendar_carrec;
            $calendari->id_director = $actorEstadillo->estadillo->registreProduccio->id_director;
            $calendari->save();
            
            return response()->json("Tot Ok!");
        }
    }

    public function delete($id){
        $calendari = Calendar::findOrFail($id);
        $calendari->delete();
       
        return response()->json("Esborrat Ok!");
    }
    
    
    public function calendariCarrecInsertar(){
        $v = Validator::make(request()->all(),[
            //'id_calendar'=>'required|max:35',
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

    public function calendariCarrecDelete($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $calendariCarrec->delete();
       
        return redirect()->route('showCalendari');
    }

    public function cogerCalendarioActor() {
        $calendar = Calendar::with('actorEstadillo.estadillo.registreProduccio')
                ->with('calendari')
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
