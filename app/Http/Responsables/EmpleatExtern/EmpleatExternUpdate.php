<?php
namespace App\Http\Responsables\EmpleatExtern;

use Illuminate\Contracts\Support\Responsable;
use App\{Idioma, Tarifa};

class EmpleatExternUpdate implements Responsable
{
    protected $empleat;
    protected $idioma;
    protected $carrecsData;
    protected $carrecTarifes;
    protected $tarifas;

    public function __construct($empleat)
    {
        $this->empleat = $empleat;
        $this->idioma = Idioma::select('idioma')->get();
        $this->tarifas = Tarifa::select('nombre', 'id_carrec', 'nombre_corto')->get();
        $carrecsEmpleats = $this->empleat->carrec;
        //Arrays que guardan les dades dels arrays i les tarifes per mostrar-les en el frontend
        $this->carrecsData = [];
        $this->carrecTarifes = [];

        foreach ($carrecsEmpleats as $key => $carrecEmp) {
            if ($carrecEmp->id_idioma == 0) {
                $this->carrecsData[$carrecEmp->carrec->input_name][$carrecEmp->tarifa->nombre_corto] = array(
                    'preu_carrec' => $carrecEmp->preu_carrec,
                );
                $this->carrecsData[$carrecEmp->carrec->input_name]['contracta'] = $carrecEmp->contracta;
            } else {
                if ($carrecEmp->id_carrec == 1) {       
                    $this->carrecsData[$carrecEmp->carrec->input_name][$carrecEmp->idioma->idioma][$carrecEmp->tarifa->nombre_corto] = array(
                        'preu_carrec' => $carrecEmp->preu_carrec,
                    );    
                    $this->carrecsData[$carrecEmp->carrec->input_name]['contracta'] = $carrecEmp->contracta;
                }
                else {
                    $this->carrecsData[$carrecEmp->carrec->input_name][$carrecEmp->idioma->idioma] = array(
                        'empleat_homologat' => $carrecEmp->empleat_homologat,
                        'rotllo' => $carrecEmp->rotllo,
                    );
                    $this->carrecsData[$carrecEmp->carrec->input_name]['contracta'] = $carrecEmp->contracta;
                    $this->carrecTarifes[$carrecEmp->carrec->input_name][$carrecEmp->idioma->idioma][$carrecEmp->tarifa->nombre_corto] = array(
                        'preu_carrec' => $carrecEmp->preu_carrec,
                    ); 
                }
            }
        }
    }

    public function toResponse($request)
    {
        return View('empleats_externs.create', [
            'empleat' => $this->empleat,
            'idiomes' => $this->idioma ,
            'carrecs' => $this->carrecsData,
            'carrec_tarifa' => $this->carrecTarifes,
            'tarifas' => $this->tarifas ,
        ]);
    }
}