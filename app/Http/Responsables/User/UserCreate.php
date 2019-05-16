<?php
namespace App\Http\Responsables\User;

use Illuminate\Contracts\Support\Responsable;
use App\Departament;
class UserCreate implements Responsable
{
    protected $user;
    protected $departaments;

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
