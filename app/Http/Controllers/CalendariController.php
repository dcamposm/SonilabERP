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
                                    //->with("actorEstadillo")
                                    ->with('actorEstadillo.estadillo.registreProduccio.registreEntrada')
                                    ->get());

        //return response()->json($data);
        
        $urlBase = route('showCalendari');

        //ToDo: Hacerlo algún día en Eloquent... (?)
        /*$takes_restantes = DB::select('SELECT id_actor_estadillo, (t4.take_estadillo - sum(t1.num_takes)) as takes_restantes, t4.id_actor, t6.id as id_registre_produccio
        FROM slb_calendars t1, slb_actors_estadillo t4, slb_estadillo t5, slb_registres_produccio t6
        where (t1.asistencia = 1 or t1.asistencia is null)
            and t1.id_actor_estadillo in (SELECT id 
                                                FROM slb_actors_estadillo t2
                                                where t2.id_produccio in (select id_estadillo from slb_estadillo t3 
                                                    where t3.id_registre_produccio in (select id from slb_registres_produccio t7 where t7.estat = "Pendent")))
            and t1.id_actor_estadillo = t4.id    
            and t5.id_estadillo = t4.id_produccio
            and t5.id_registre_produccio = t6.id
        group by id_actor_estadillo');       */         
        
        $takes_restantes = ActorEstadillo::select('id as id_actor_estadillo', 'id', 'take_estadillo as takes_restantes', 'id_actor', 'id_produccio')
                                            ->with(['estadillo' => function($query) {
                                                $query->select('id_estadillo','id_registre_produccio')
                                                    ->with(['registreProduccio' => function($query){
                                                        $query->whereEstat('Pendent')->select('id');
                                                    }]);
                                            }])->get();
                                  
        //$estadillo = \App\Estadillo::with('actors')->get();
        //return response()->json($takes_restantes);

        foreach ($takes_restantes as $key => $value) {
            if ($value->estadillo != null) {
                if ($value->estadillo->registreProduccio != null){
                    $empleado = EmpleatExtern::findOrFail($value->id_actor);
                    $produccio = RegistreProduccio::findOrFail($value->estadillo->id_registre_produccio);
                    $entrada = RegistreEntrada::findOrFail($produccio->id_registre_entrada);
                    $value->nombre_actor = $empleado->nom_cognom;
                    $value->nombre_reg_entrada = $entrada->titol;
                    $value->nombre_reg_produccio = $produccio->titol;
                    if ($value->calendar != null){
                        $value->takes_restantes = $value->takes_restantes - $value->calendar->num_takes;
                    } 
                } else {
                    //return response()->json($key);
                    unset($takes_restantes[$key]);
                    //return response()->json($takes_restantes);
                }
                
            } else {
                //return response()->json($key);
                unset($takes_restantes[$key]);
                //return response()->json($takes_restantes);
            }
        }
        //return response()->json($takes_restantes);
        
        $actores = json_encode($takes_restantes);
        //return response()->json($actores);
        $todosActores = DB::select('SELECT t1.id_empleat, t1.nom_empleat, t1.cognom1_empleat, t1.cognom2_empleat
                                        FROM slb_empleats_externs t1, slb_carrecs_empleats t2
                                            WHERE t2.id_carrec = 1 and t1.id_empleat = t2.id_empleat
                                        GROUP by id_empleat');

        $peliculas = RegistreEntrada::all();
        
        $tecnics = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                  ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                  ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                  ->distinct()->where('slb_carrecs.nom_carrec', '=', 'Tècnic de sala')
                                  ->get();
        $directors = EmpleatExtern::select('slb_empleats_externs.id_empleat', 'slb_empleats_externs.nom_empleat', 'slb_empleats_externs.cognom1_empleat', 'slb_empleats_externs.cognom2_empleat')
                                    ->join('slb_carrecs_empleats', 'slb_carrecs_empleats.id_empleat', '=', 'slb_empleats_externs.id_empleat')
                                    ->join('slb_carrecs', 'slb_carrecs.id_carrec', '=', 'slb_carrecs_empleats.id_carrec')
                                    ->distinct()->where('slb_carrecs.nom_carrec', '=', 'Director')
                                    ->get();
        
        // TODO: Hacer que los actores no se repitan o que si se repiten que se coja también la hora.
        $actoresPorDia = array();
        foreach($fechas as $key => $fech) {
            $diaz = DateTime::createFromFormat("d-m-Y", $fech);
            $act_dia = DB::select(
                'SELECT t1.id_empleat, t1.nom_empleat, t1.cognom1_empleat, t1.cognom2_empleat, t2.id_calendar, 
                    DAY(t2.data_inici) as dia, t2.num_sala , LPAD(HOUR(t2.data_inici), 2, 0) as hora, 
                    LPAD(MINUTE(t2.data_inici), 2, 0) as minuts, 
                    t3.id as id_actor_estadillo, t2.id_calendar as id_calendar 
                FROM slb_empleats_externs t1, slb_calendars t2, slb_actors_estadillo t3
                WHERE 
                    t2.id_actor_estadillo = t3.id AND t3.id_actor = t1.id_empleat AND 
                    DAY(t2.data_inici) = '.$diaz->format('d').' AND MONTH(t2.data_inici) = '.$diaz->format('m').' 
                    AND YEAR(t2.data_inici) = '.$diaz->format('Y').' 
                ORDER BY t2.data_inici asc'
            );
            array_push($actoresPorDia, $act_dia);
        }
        //return response()->json($actoresPorDia);
        $directoresAsignados = CalendarCarrec::where('data', '>=', $dia1)->where('data', '<=', $dia5)->get();
        
        return View('calendari.index', ["fechas"    => $fechas, 
                                        "week"      => $week,
                                        "year"      => $year,
                                        "urlBase"   => $urlBase,
                                        "actores"   => $actores,
                                        "tecnics"   => $tecnics,
                                        "directors" => $directors,
                                        "data"      => $data,
                                        "todosActores"   =>$todosActores,
                                        "registrosEntrada"=>$peliculas,
                                        "actoresPorDia" => $actoresPorDia,
                                        "directoresAsignados" => $directoresAsignados]);
    }

    public function cambiarCargo(Request $request) {
        // Coge todos los parámetros necesarios:
        $data       = strtotime($request->get('data'));
        $data       = date('Y-m-d H:i:s', $data);
        $sala       = $request->get('sala');
        $id_empleat = $request->get('id_empleat');
        $torn       = $request->get('torn');
        // Coge el identificador del cargo dependiendo del cargo que le pasemos en la consulta:
        $id_carrec  = Carrec::select('id_carrec')->where('nom_carrec', '=', $request->get('cargo'))->first()->id_carrec;

        // Comprueba si ya existe un registro en la base de datos:
        $calendariCarrec = CalendarCarrec::where('data', '=', $data)
                                           ->where('id_carrec', '=', $id_carrec)
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
        $calendariCarrec->id_carrec  = $id_carrec;
        $calendariCarrec->torn       = $torn;

        // Guardamos el objeto en la base de datos:
        $calendariCarrec->save();

        // Retornamos el resultado para indicar que todo ha ido OK:
        return response()->json([
            $data,
            $sala,
            $id_empleat,
            $id_carrec,
            $torn
        ]);
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

            $calendari = new Calendar($requestData);  
            $calendari->save();
            return response()->json(['success'=> true,'calendari'=>$calendari],201);
        }
    }

    public function update($id){
        $calendari = Calendar::findOrFail($id);
        // return response()->json(request()->get('data_inici_h'));

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
            //return response()->json(request()->all());
            // Datos correctos.
            $calendari->fill($valores);  
            $calendari->save();

            // Guardamos el identificador de la película:
            $this->updateProduccion(request()->get('id_actor_estadillo'), request()->get('id_produccio'));

            return response()->json("Tot Ok!");
        }
    }

    private function updateProduccion($id_actor_estadillo, $id_produccio) {
        $actorEstadillo = ActorEstadillo::find($id_actor_estadillo);
        if (empty($actorEstadillo) == false) {
            $actorEstadillo->id_produccio = $id_produccio;
            $actorEstadillo->save();
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

    public function calendariCarrecDelete($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $calendariCarrec->delete();
       
        return redirect()->route('showCalendari');
    }

    public function cogerCalendarioActor() {
        $calendar = Calendar::find(request()->get('id'));
        $peliculas = collect(DB::select('select t1.* from slb_registres_produccio t1 INNER JOIN slb_actors_estadillo t2 ON t1.id = t2.id_produccio WHERE t2.id = '.$calendar->id_actor_estadillo))->first();
        return response()->json(array(
            'calendar'  => $calendar,
            'peliculas' => $peliculas
        ));
    }

    public function getPeliculas() {
        $peliculas = RegistreProduccio::all();
        return $peliculas;
    }
}
