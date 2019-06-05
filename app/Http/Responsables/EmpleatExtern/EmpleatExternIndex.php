<?php
namespace App\Http\Responsables\EmpleatExtern;

use Illuminate\Contracts\Support\Responsable;
use App\Carrec;

class EmpleatExternIndex  implements Responsable
{
    protected $empleats;
    protected $carrecs;
    protected $empleatsArray;

    public function __construct($empleats)
    {
        $this->empleats = $empleats; 
        $this->carrecs = Carrec::all();
        $this->empleatsArray = array();
        
        foreach ($empleats as $empleat) {
            foreach( $empleat->carrec as $empleatCarrec ){
                //Comprova que el carrec no estigui repetit;
                isset($this->empleatsArray[$empleat->id_empleat][$empleatCarrec->carrec->nom_carrec]) ? '' : $this->empleatsArray[$empleat->id_empleat][$empleatCarrec->carrec->nom_carrec] = $empleatCarrec->carrec->nom_carrec;
            }
        } 
    }

    public function toResponse($request)
    {
        return view('empleats_externs.index', [
            'empleats' => $this->empleats,
            'carrecs' => $this->carrecs,
            'empleatsArray' => $this->empleatsArray
        ]);
    }
}