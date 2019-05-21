<?php
namespace App\Http\Responsables\Estadillo;

use Illuminate\Contracts\Support\Responsable;
use App\EmpleatExtern;

class EstadilloShowActor  implements Responsable
{
    protected $actors;
    protected $empleats;
    protected $estadillos;
    
    public function __construct($actor, $estadillo)
    {
        $this->actors = $actor; //Busca tots els actors que participin amb l'estadillo
        $this->empleats = EmpleatExtern::all();
        $this->estadillos = $estadillo; //Busca l'estadillo
    }

    public function toResponse($request)
    {
        return view('estadillos.showActor', [
            'actors'        => $this->actors,
            'empleats'      => $this->empleats,
            'estadillos'    => $this->estadillos
        ]);
    }
}
