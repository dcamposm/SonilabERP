<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarrecEmpleat extends Model
{
    protected $table = 'slb_carrecs_empleats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empleat',
        'id_carrec',
        'id_idioma',
        'empleat_homologat',
        'preu_carrec1',
        'preu_carrec2',
        'preu_docu',
        'preu_video_tk',
        'preu_video_cg',
        'preu_cine_tk',
        'preu_cine_cg'
    ];

    public function empleat()
    {
        return $this->belongsTo('App\EmpleatExtern', 'id_empleat', 'id_empleat');
    }

    public function idioma()
    {
        return $this->belongsTo('App\Idioma', 'id_idioma', 'id_idioma');
    }

    public function carrec()
    {
        return $this->belongsTo('App\Carrec', 'id_carrec', 'id_carrec');
    }
}
