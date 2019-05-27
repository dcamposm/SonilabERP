<?php
namespace App\Http\Responsables\EmpleatExtern;

use Illuminate\Contracts\Support\Responsable;
use App\Tarifa;

class EmpleatExternShow   implements Responsable
{
    protected $empleat;
    protected $carrecsEmpelat;
    protected $tarifas;

    public function __construct($empleat)
    {
        $this->empleat = $empleat;
        $this->tarifas = Tarifa::all();
        $this->carrecsEmpelat = array();
        
        $carrecs = $this->empleat->carrec;
        // Crea el objeto "carrecsEmpelat" para mostrar las tablas de cargos i tarifas en el frontend
        foreach ($carrecs as $key => $carrec) {
            $idioma = $carrec->idioma;
            $tarifa = $carrec->tarifa;
            //return response()->json($carrec);
            $this->carrecsEmpelat[$carrec->carrec->nom_carrec]['contracta'] = $carrec->contracta;
            $this->carrecsEmpelat[$carrec->carrec->nom_carrec][(empty($idioma)) ? 0 : $idioma->idioma][$carrec->id] = array(
                'nomCarrec' => $carrec->carrec->nom_carrec,
                'empleat_homologat' => $carrec->empleat_homologat,
                'rotllo' => $carrec->rotllo,
                'preu_carrec' => $carrec->preu_carrec,
                'id_tarifa' => $tarifa->id,
                'tarifa' => $tarifa->nombre,
            );
        }
    }

    public function toResponse($request)
    {
        return View('empleats_externs.show', [
            'empleat' => $this->empleat,
            'carrecsEmpelat' => $this->carrecsEmpelat,
            'tarifas' => $this->tarifas,
        ]);
    }
}
