<?php
namespace App\Http\Responsables\RegistreEntrada;

use Illuminate\Contracts\Support\Responsable;

class RegistreEntradaShow implements Responsable
{
    protected $registreEntrades;
    protected $missatge;

    public function __construct($registre, $missatges = null)
    {
        $this->registreEntrades = $registre; 
        
        if ($missatges != null) {
            foreach ($missatges as $key => $missatge){
                $this->missatge[$missatge->missatge] = $missatge->missatge;
            }
        }
    }

    public function toResponse($request)
    {
        //return response()->json($this->missatge);
        return View('registre_entrada.show', [
            'registreEntrada' => $this->registreEntrades,
            'missatges' => $this->missatge
        ]);
    }
}
