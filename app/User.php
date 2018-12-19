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

    /**
     * Especifica el nom del camp de la contrasenya al model
     * 
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasenya_usuari;
    }

    /**
     * Retorna el token de l'usuari que vol iniciar sessió.
     * 
     * @return string
     */
    public function getRememberToken()
    {
        return $this->token;
    }

    /**
     * Asigna un nou valor per al token de l'usuari que ha iniciat sessió.
     * 
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    /**
     * Especifica el nom del camp del token al model
     * 
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'token';
    }
}
