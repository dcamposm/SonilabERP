<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpleatExtern extends Model
{
    protected $table = 'slb_empleats_externs';
    protected $primaryKey = 'id_empleat';

    protected $fillable = [
        "nom_empleat", 
        "cognoms_empleat", 
        "sexe_empleat", 
        "nacionalitat_empleat", 
        "imatge_empleat",
        "email_empleat", 
        "dni_empleat", 
        "telefon_empleat", 
        "direccio_empleat", 
        "codi_postal_empleat", 
        "naixement_empleat", 
        "nss_empleat", 
        "iban_empleat"
    ];

}
