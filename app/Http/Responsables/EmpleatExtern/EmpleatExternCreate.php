<?php
namespace App\Http\Responsables\EmpleatExtern;

use Illuminate\Contracts\Support\Responsable;
use App\{Idioma, Tarifa};

class EmpleatExternCreate  implements Responsable
{
    protected $idioma;
    protected $tarifas;

    public function __construct()
    {
        $this->idioma = Idioma::select('idioma')->get();
        $this->tarifas = Tarifa::select(['nombre', 'id_carrec'])->get();
    }

    public function toResponse($request)
    {
        return View('empleats_externs.create', [
            'idiomes' => $this->idioma,
            'tarifas' => $this->tarifas
        ]);
    }
}