<?php
namespace App\Http\Responsables\Estadillo;

use Illuminate\Contracts\Support\Responsable;
use App\{Estadillo,RegistreProduccio};

class EstadilloIndex implements Responsable
{
    protected $showEstadillos;
    protected $arrayProjectes;

    public function __construct($estadillos)
    {
        $this->showEstadillos = array();
        $this->arrayProjectes = array();
        
        foreach ($estadillos as $estadillo){
            if ($estadillo->registreProduccio->subreferencia!=0){
                if (!isset($this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada])){
                    $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                        'titol'=>$estadillo->registreProduccio->titol,
                        'setmana' => $estadillo->registreProduccio->setmana,
                        'min'=>$estadillo->registreProduccio->subreferencia,
                        'max'=>$estadillo->registreProduccio->subreferencia,
                        'validat'=>$estadillo->registreProduccio->estadillo
                    );
                } else {
                    if(!isset($this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana])){
                        $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                            'titol'=>$estadillo->registreProduccio->titol,
                            'setmana' => $estadillo->registreProduccio->setmana,
                            'min'=>$estadillo->registreProduccio->subreferencia,
                            'max'=>$estadillo->registreProduccio->subreferencia,
                            'validat'=>$estadillo->registreProduccio->estadillo
                        );
                    } else {
                        if ($this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max']<$estadillo->registreProduccio->subreferencia){
                            $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['max'] = $estadillo->registreProduccio->subreferencia;
                        } else if ($this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min']>$estadillo->registreProduccio->subreferencia){
                            $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['min'] = $estadillo->registreProduccio->subreferencia;
                        }
                        if ($estadillo->registreProduccio->estadillo == 0){
                            $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]['validat'] = $estadillo->registreProduccio->estadillo;
                        }
                    }
                }
            } else {
                $this->showEstadillos[$estadillo->registreProduccio->id_registre_entrada][$estadillo->registreProduccio->setmana]= array(
                    'id_estadillo'=>$estadillo->id_estadillo,
                    'setmana' => $estadillo->registreProduccio->setmana,
                    'titol'=>$estadillo->registreProduccio->titol,
                    'validat'=>$estadillo->registreProduccio->estadillo
                );
            }
        }
        //select crear estadillo
        $estadillos = Estadillo::all();
        $registreProduccio = RegistreProduccio::all();
        
        $cont = 0;
        $exist = false;
        
        foreach ($registreProduccio as $projecte){
            foreach ($estadillos as $estadillo) {
                if ($projecte->id == $estadillo->id_registre_produccio){
                    $exist = true;
                }
            }
            if ($exist == false) {
                $this->arrayProjectes[$cont] = $projecte;
                $cont++;
            } else {
                $exist = false;
            }
        }
    }

    public function toResponse($request)
    {
        return View('estadillos.index', [
            'showEstadillos' => $this->showEstadillos,
            'registreProduccio'=>$this->arrayProjectes
        ]);
    }
}
