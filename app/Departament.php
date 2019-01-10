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
}
