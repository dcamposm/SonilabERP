<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $table = 'SLB_DEPARTAMENTS';
    protected $primaryKey = 'id_departament';

    protected $fillable = [
        'nom_departament',
        'descripcio_departament'
    ];

    /**
     * - Indica el tipo de relación del campo especificado.
     * - En este caso le estamos diciendo que el campo "id_departament" pertenece al
     * "id_departament" de modelo User.
     * - Esta función retornará un listado de usuarios los cuales pertenecen a este departamento.
     */
    public function users()
    {
        return $this->hasMany('App\User', 'id_departament', 'id_departament');
    }
}
