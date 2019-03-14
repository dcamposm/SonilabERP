<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projecte extends Model
{
    protected $table = 'slb_registre_produccio';
    protected $primaryKey = 'id';

    public $fillable = [
        'id_registre_entrada',
        'id_sub',
        'nom',
        'estadillo',
        'descripcio'
    ];

    /**
     * - Indica el tipo de relación del campo especificado.
     * - En este caso le estamos diciendo que el campo "id_projecte" pertenece al
     * "id_projecte" de modelo User.
     * - Esta función retornará un listado de usuarios los cuales pertenecen a este proyecto.
     */    
    public function estadillo()
    {
        return $this->BelongTo('App\Estadillo', 'estadillo', 'id_estadillo');
    }
}
