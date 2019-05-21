<?php
namespace App\Http\Responsables\Estadillo;

use Illuminate\Contracts\Support\Responsable;
use App\RegistreProduccio;
use App\Estadillo;
use App\EmpleatExtern;
use App\ActorEstadillo;

class EstadilloShowActorSetmana  implements Responsable
{
    protected $actors;
    protected $empleats;
    protected $estadillos;
    protected $registres;
    protected $min;
    protected $max;
    
    public function __construct($id, $setmana)
    {
        $this->empleats = EmpleatExtern::all();
        $this->actors = array();
        $registresProduccio = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->get();
        
        foreach ($registresProduccio as $registre) {
            $estadillo = Estadillo::where('id_registre_produccio', $registre['id'])->first();
            if ($estadillo){
                $actors = ActorEstadillo::where('id_produccio', $estadillo['id_estadillo'])->get();
                
                foreach ($actors as $actor) {  
                    if (!isset($this->actors[$actor['id_actor']])){
                        $this->actors[$actor['id_actor']] = array(
                            'id_actor' => $actor['id_actor'],
                            'cg_estadillo' =>  $actor['cg_estadillo'],
                            'canso_estadillo' =>  $actor['canso_estadillo'],
                            'take_estadillo' => $actor['take_estadillo']
                        );
                    } else {
                        $this->actors[$actor['id_actor']]['cg_estadillo']+=($actor['cg_estadillo'] != null  ? $actor['cg_estadillo'] : 0);
                        $this->actors[$actor['id_actor']]['take_estadillo']+=$actor['take_estadillo'];
                        if ($actor['canso_estadillo'] == 1) {
                            $this->actors[$actor['id_actor']]['canso_estadillo'] = $actor['canso_estadillo'];
                        }
                    }
                }  
                
                if (!isset($this->min)) {
                    $this->min = $registre['subreferencia'];
                    $this->max = $registre['subreferencia'];
                } else {
                    if ($registre['subreferencia'] < $this->min){
                        $this->min = $registre['subreferencia'];
                    } else if ($registre['subreferencia'] > $this->max) {
                        $this->max = $registre['subreferencia'];
                    }
                }
                $this->estadillos = Estadillo::where('id_registre_produccio', $registre['id'])->first()->registreProduccio;
            }
        }

        $this->registres = RegistreProduccio::where('id_registre_entrada', $id)->where('setmana', $setmana)->first();
    }

    public function toResponse($request)
    {
        //return response()->json($this->registres);
        return view('estadillos.showActor', array(
            'actors'    => $this->actors,
            'empleats'    => $this->empleats,
            'estadillos' => $this->estadillos,
            'registreProduccio' => $this->registres,
            'min' => $this->min,
            'max' => $this->max
        ));
    }
}