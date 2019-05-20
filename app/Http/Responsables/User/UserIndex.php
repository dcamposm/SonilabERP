<?php
namespace App\Http\Responsables\User;

use Illuminate\Contracts\Support\Responsable;
use App\Departament;
class UserIndex  implements Responsable
{
    protected $user;
    protected $departaments;

    public function __construct($user)
    {
        $this->user = $user; 
        $this->departaments = Departament::all();
    }

    public function toResponse($request)
    {
        return view('usuaris_interns.index',[
            'arrayUsuaris' => $this->user,
            'departaments' => $this->departaments
        ]);
    }
}
