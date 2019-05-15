<?php
namespace App\Http\Responsables\User;

use Illuminate\Contracts\Support\Responsable;

class UserCreate implements Responsable
{
    protected $user;
    protected $departaments;

    public function __construct($departaments, $user = array())
    {
        $this->user = $user; 
        $this->departaments = $departaments; 
    }

    public function toResponse($request)
    {
        //return $this->getUser();
        return view("usuaris_interns.create",[
            'departaments' => $this->departaments,
            'usuario' => $this->user
        ]);
    }
}
