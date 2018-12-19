<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $table = 'SLB_DEPARTAMENTS';

    public $timestamps = false;

    protected $primaryKey = 'id_departament';

    
}
