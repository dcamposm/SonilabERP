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
                                    ->with('actorEstadillo.registreEntrada')
                                    ->get());

        
        $urlBase = route('showCalendari');

        //ToDo: Hacerlo algún día en Eloquent... (?)
        $takes_restantes = DB::select('SELECT id_actor_estadillo, (t4.take_estadillo - sum(t1.num_takes)) as takes_restantes, t4.id_actor, t5.id as id_registre_produccio
        FROM slb_db.slb_calendars t1, slb_actors_estadillo t4, slb_registres_produccio t5
        where (t1.asistencia = 1 or t1.asistencia is null)
            and t1.id_actor_estadillo in (SELECT id 
                                                FROM slb_db.slb_actors_estadillo t2
                                                where t2.id_produccio in (select id from slb_registres_produccio t3 where t3.estat = "Pendent"))
            and t1.id_actor_estadillo = t4.id    
            and t5.id = t4.id_produccio
        group by id_actor_estadillo');
        

        foreach ($takes_restantes as $value) {
            $empleado = EmpleatExtern::findOrFail($value->id_actor);
            $produccio = RegistreProduccio::findOrFail($value->id_registre_produccio);
            $entrada = RegistreEntrada::findOrFail($produccio->id_registre_entrada);
            $value->nombre_actor = $empleado->nom_empleat.' '.$empleado->cognom1_empleat.' '.$empleado->cognom2_empleat;
            $value->nombre_reg_entrada = $entrada->titol;
            $value->nombre_reg_produccio = $produccio->titol_traduit;
        }

        $actores = json_encode($takes_restantes);
        $todosActores = DB::select('SELECT t1.id_empleat, t1.nom_empleat, t1.cognom1_empleat, t1.cognom2_empleat
        FROM slb_db.slb_empleats_externs t1, slb_carrecs_empleats t2
            WHERE t2.id_carrec = 1 and t1.id_empleat = t2.id_empleat
        GROUP by id_empleat');

        $peliculas = RegistreEntrada::all();
        
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
        
        // TODO: Hacer que los actores no se repitan o que si se repiten que se coja también la hora.
        $actoresPorDia = array();
        foreach($fechas as $key => $fech) {
            $diaz = DateTime::createFromFormat("d-m-Y", $fech);
            $act_dia = DB::select(
                'SELECT t1.id_empleat, t1.nom_empleat, t1.cognom1_empleat, t1.cognom2_empleat, t2.id_calendar, 
                    DAY(t2.data_inici) as dia, t2.num_sala , LPAD(HOUR(t2.data_inici), 2, 0) as hora, 
                    LPAD(MINUTE(t2.data_inici), 2, 0) as minuts 
                FROM slb_empleats_externs t1 INNER JOIN slb_calendars t2 ON t1.id_empleat = t2.id_actor_estadillo 
                WHERE DAY(t2.data_inici) = '.$diaz->format('d').' AND MONTH(t2.data_inici) = '.$diaz->format('m').' 
                    AND YEAR(t2.data_inici) = '.$diaz->format('Y').' 
                ORDER BY t2.data_inici asc'
            );
            array_push($actoresPorDia, $act_dia);
        }

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
            'id_actor_estadillo'=>'required|max:35',
            'num_takes'=>'required|regex:/^[0-9]+$/',//^[0-9]+$
            'data_inici'=>'required|max:35',
            'data_fi'=>'required|max:35',
            'num_sala'=>'required|max:35'
            
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

    public function calendariCarrecDelete($id){
        $calendariCarrec = CalendarCarrec::findOrFail($id);
        $calendariCarrec->delete();
       
        return redirect()->route('showCalendari');
    }
}
