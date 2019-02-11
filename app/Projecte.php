<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projecte extends Model
{
    protected $table = 'SLB_PROJECTES';
    protected $primaryKey = 'id_projecte';

    protected $fillable = [
        'nom_projecte',
        'descripcio_projecte'
    ];

    /**
     * - Indica el tipo de relación del campo especificado.
     * - En este caso le estamos diciendo que el campo "id_projecte" pertenece al
     * "id_projecte" de modelo User.
     * - Esta función retornará un listado de usuarios los cuales pertenecen a este proyecto.
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_projecte', 'id_projecte');
    }
}
