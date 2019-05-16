<?php
namespace App\Http\Responsables\RegistreEntrada;

use Illuminate\Contracts\Support\Responsable;
use App\Client;
use App\Servei;
use App\Idioma;
use App\TipusMedia;
use App\User;

class RegistreEntradaIndex  implements Responsable
{
    protected $registreEntrades;
    protected $clients;
    protected $serveis;
    protected $idiomes;
    protected $medies;
    protected $usuaris;

    public function __construct($registre)
    {
        $this->registreEntrades = $registre; 
        $this->clients = Client::all();
        $this->serveis = Servei::all();
        $this->idiomes = Idioma::all();
        $this->medies = TipusMedia::all();
        $this->usuaris = User::where('id_departament', '2')->get();
    }

    public function toResponse($request)
    {
        return View('registre_entrada.index', [
            'registreEntrades' => $this->registreEntrades,
            'clients' => $this->clients,
            'serveis' => $this->serveis,
            'idiomes' => $this->idiomes,
            'medies' => $this->medies,
            'usuaris' => $this->usuaris
        ]);
    }
}
