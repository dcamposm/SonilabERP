<?php

namespace App\Imports;

use App\ActorEstadillo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\EmpleatExtern;

class ActorEstadilloImport implements ToModel, WithHeadingRow
{
    /*
     * Classe que s'utilitza per fer l'importació dels estadillos.
     */
    protected $id_estadillo;
    public $errors;

    public function __construct($id)
    {
        $this->id_estadillo = $id; 
        $this->errors = [];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        
        if (!is_null($row['nom'])){
            //Primer busquem si existeix l'actor
            $actor = EmpleatExtern::whereRaw('LOWER(nom_empleat) like "%'. trim(mb_strtolower($row['nom']), " ").'%"'
                    . 'AND LOWER(cognom1_empleat) like "%'. trim(mb_strtolower($row['cognom']), " ").'%"')->first();
            //Si extisteix actulitza o crear un registre a la taula slb_actors_estadillos 
            //de la base de dades.
            if ($actor){
                $actorEstadillo = ActorEstadillo::where('id_produccio' , $this->id_estadillo)
                                ->where('id_actor',$actor->id_empleat)->first();
                if ($actorEstadillo){
                    $actorEstadillo->update([
                        'id_produccio' => $this->id_estadillo,
                        'id_actor' => $actor->id_empleat,
                        'take_estadillo' => trim($row['tks_tot'], " "),
                        'cg_estadillo' => trim($row['cg'], " "),
                        'canso_estadillo' => is_null($row['n']) ? 0 : 1,
                        'narracio_estadillo' => is_null($row['c']) ? 0 : 1,
                    ]);
                    
                    return ;
                } else {
                    return ActorEstadillo::updateOrCreate([
                        'id_produccio' => $this->id_estadillo,
                        'id_actor' => $actor->id_empleat,
                        'take_estadillo' => trim($row['tks_tot'], " "),
                        'cg_estadillo' => trim($row['cg'], " "),
                        'canso_estadillo' => is_null($row['n']) ? 0 : 1,
                        'narracio_estadillo' => is_null($row['c']) ? 0 : 1,
                    ]);
                    
                    return ;
                }  
            }
            //Si no existeix guarda l'actor amb un missatge d'error.
            array_push ($this->errors , 'ERROR. El actor '.$row['nom'].' '.$row['cognom'].' no existeix.');
        }
        
        return ;
    }
}
