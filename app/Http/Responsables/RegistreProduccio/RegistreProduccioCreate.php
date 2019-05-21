<?php
namespace App\Http\Responsables\RegistreProduccio;

use Illuminate\Contracts\Support\Responsable;
use App\{EmpleatExtern,RegistreEntrada};

class RegistreProduccioCreate implements Responsable
{
    protected $registreProduccio;
    protected $empleats;
    protected $regEntrades;

    public function __construct($registreProduccio = array())
    {
        $this->registreProduccio = $registreProduccio; 
        $this->empleats = EmpleatExtern::all();
        $this->regEntrades = $regEntrades = RegistreEntrada::all();
    }

    public function toResponse($request)
    {
        return view('registre_produccio.create', [
            'registreProduccio' => $this->registreProduccio,
            'empleats' => $this->empleats,
            'regEntrades' => $this->regEntrades 
        ]);
    }
}