<?php
namespace App\Http\Responsables\User;

use Illuminate\Contracts\Support\Responsable;

class UserIndex  implements Responsable
{
    protected $user;
    protected $departaments;

    public function __construct($user, $departaments)
    {
        $this->user = $user; 
        $this->departaments = $departaments; 
    }

    public function toResponse($request)
    {
        //return $this->getUser();
        return view('usuaris_interns.index',[
            'arrayUsuaris' => $this->user,
            'departaments' => $this->departaments
        ]);
    }
}
