<?php
namespace App\Http\Responsables\RegistreProduccio;

use Illuminate\Contracts\Support\Responsable;
use App\{EmpleatExtern,RegistreEntrada};

class RegistreProduccioShow implements Responsable
{
    protected $registreProduccio;
    protected $empleados;
    protected $empleatsCarrec;
    protected $regEntrades;

    public function __construct($registreProduccio)
    {
        $this->registreProduccio = $registreProduccio; 
        $this->empleados = [];
        $this->empleatsCarrec = EmpleatExtern::with('carrec')->get();
        $this->regEntrades = RegistreEntrada::all();
        
        $traductor   = EmpleatExtern::find($registreProduccio->id_traductor);
        $ajustador   = EmpleatExtern::find($registreProduccio->id_ajustador);
        $linguista   = EmpleatExtern::find($registreProduccio->id_linguista);
        $director    = EmpleatExtern::find($registreProduccio->id_director);
        $tecnic_mix  = EmpleatExtern::find($registreProduccio->id_tecnic_mix);

        if ($traductor)     $this->empleados["traductor"]  = $traductor;
        if ($ajustador)     $this->empleados["ajustador"]  = $ajustador;
        if ($linguista)     $this->empleados["linguista"]  = $linguista;
        if ($director)      $this->empleados["director"]   = $director;
        if ($tecnic_mix)    $this->empleados["tecnic_mix"] = $tecnic_mix;
    }

    public function toResponse($request)
    {
        return view('registre_produccio.show', [
            'registreProduccio' => $this->registreProduccio,
            'empleats'          => $this->empleados,
            'empleatsCarrec'    => $this->empleatsCarrec,
            'regEntrades'       => $this->regEntrades
        ]);
    }
}
