<?php
namespace App\Http\Responsables\RegistreProduccio;

use Illuminate\Contracts\Support\Responsable;
use App\{Missatge,RegistreEntrada};

class RegistreProduccioIndex implements Responsable
{
    protected $missatges;
    protected $registreProduccio;
    protected $registreEntrada;
    
    public function __construct($registres)
    {
        $this->missatges = Missatge::whereReferencia('registreProduccio')->get();
        $this->registreEntrada = RegistreEntrada::whereEstat('Pendent')->get();
        $this->registreProduccio = array();
        
        foreach ($registres as $registre){
            if ($registre->subreferencia == 0){
                $this->registreProduccio[$registre->id_registre_entrada] = $registre;
            } else {
                if (!isset($this->registreProduccio[$registre->id_registre_entrada][$registre->setmana])){
                    $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0] = array(
                        'id_registre_entrada' => $registre->id_registre_entrada,
                        'min' => $registre->subreferencia,
                        'max' => $registre->subreferencia,
                        'titol' => $registre->registreEntrada->titol,
                        'data' => $registre->data_entrega,
                        'setmana' => $registre->setmana,
                        'estadillo' => $registre->estadillo,
                        'vec' => $registre->vec,
                        'estat' => $registre->estat,
                        'new' => 0
                    );
                    
                    foreach ($this->missatges as $missatge) {
                        if ($missatge->id_referencia == $registre->id){
                            $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['new'] = 1;
                        }
                    }
                    
                    $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][$registre->subreferencia] = $registre;
                } else {
                    if ($this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['max'] < $registre->subreferencia) {
                        $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['max'] = $registre->subreferencia;
                    } else if ($this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['min'] > $registre->subreferencia){
                        $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['min'] = $registre->subreferencia;
                    }
                    
                    if ($registre->estadillo == 0) {
                        $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['estadillo'] = 'Pendent';
                    }
                    
                    if ($registre->estat == 'Pendent') {
                        $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['estat'] = 'Pendent';
                    }
                    
                    foreach ($this->missatges as $missatge) {
                        if ($missatge->id_referencia == $registre->id){
                            $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][0]['new'] = 1;
                        }
                    }
                    
                    $this->registreProduccio[$registre->id_registre_entrada][$registre->setmana][$registre->subreferencia] = $registre;
                }  
            }
        }
    }

    public function toResponse($request)
    {
        return view('registre_produccio.index', [
            'registreProduccions' => $this->registreProduccio,
            'registreEntrades' => $this->registreEntrada,
            'missatges' => $this->missatges
        ]);
    }
}
