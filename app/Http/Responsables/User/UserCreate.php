<?php
namespace App\Http\Responsables\User;

use Illuminate\Contracts\Support\Responsable;
use App\Departament;
class UserCreate implements Responsable
{
    /*
        *Classe Responsable que gestiona el retornament a la vista create d'usuari interns
    */
    protected $user;
    protected $departaments;
    /*
        *En el constructor prepara les variables que s'envien a la vista
    */
    public function __construct($user = array())
    {
        $this->user = $user; 
        $this->departaments = Departament::all();
    }

    public function toResponse($request)
    {
        return view("usuaris_interns.create",[
            'departaments' => $this->departaments,
            'usuario' => $this->user
        ]);
    }
}
