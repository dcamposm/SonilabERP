<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'slb_clients';
    protected $primaryKey = 'id_client';

    protected $fillable = [
        'nom_client',
        'nif_client',
        'email_client',
        'telefon_client',
        'direccio_client',
        'codi_postal_client',
        'ciutat_client',
        'pais_client'
    ];

    public function registreEntrades()
    {
        return $this->hasMany('App\RegistreEntrada', 'id_client', 'id_client');
    }
}
