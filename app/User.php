<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "SLB_USUARIS";  // Especifica el nom de la taula.
    protected $primaryKey = 'id_usuari';  // Primary key de la taula.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "nom_usuari", "cognoms_usuari", "email_usuari", "alias_usuari", "contrasenya_usuari", "imatge_usuari", "id_departament"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'contrasenya_usuari', 'token'
    ];

    public function setContrasenyaUsuariAttribute($value){
        if (!empty($value)){
            $this->attributes['contrasenya_usuari'] = bcrypt($value);
        }
    }

    /**
     * Especifica el nom del camp de la contrasenya al model
     * 
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasenya_usuari;
    }
}
