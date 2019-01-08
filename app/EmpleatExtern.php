<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleatExtern extends Model
{
    protected $table = 'slb_empleats_externs';
    public $timestamps = false;
    protected $primaryKey = 'id_empleat';
}
