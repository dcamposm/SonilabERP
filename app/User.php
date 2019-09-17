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
        "cognom1_usuari",
        "cognom2_usuari",  
        "email_usuari", 
        "alias_usuari", 
        "contrasenya_usuari",
        "imatge_usuari", 
        "id_departament"
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

    protected $appends = ['nom_cognom'];
    
    public function getNomCognomAttribute() {
        return $this->alias_usuari.' '.$this->cognom1_usuari;
    }
    
    /**
     * - Indica el tipo de relación del campo especificado.
     * - En este caso le estamos diciendo que el campo "id_departament" pertenece al
     * "id_departament" de modelo Departament.
     * - Esta función retornará el departamento al que pertenezca el usuario.
     */
    public function departament()
    {
        return $this->belongsTo('App\Departament', 'id_departament', 'id_departament');
    }
    
    public function registreEntrada()
    {
        return $this->hasMany('App\RegistreEntrada', 'id_usuari', 'id_usuari');
    }
    
    public function missatge()
    {
        return $this->hasMany('App\Missatge', 'id_usuari', 'id_usuari');
    } 
    
    public function notifications()
    {
        return $this->morphMany(DatabaseMemberNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
    
    public function missatgeDay()
    {
        return $this->hasMany('App\Missatge', 'id_usuari', 'id_usuari')->where('data_final','>',date("Y-m-d"));
    }   
    //Funciones para comprobar los roles del usuario
    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        return redirect('home')->with('alert', 'WARNING. No tens accés autoritzat');
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
        if ($this->departament()->where('id_departament', $role)->first()) {
            return true;
        }
        return false;
    }
}
