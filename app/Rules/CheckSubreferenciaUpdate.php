<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\RegistreProduccio;

class CheckSubreferenciaUpdate implements Rule
{
    public $registre;
    public $ref;
    public $subref;
    
    public function __construct(RegistreProduccio $registre, String $ref, String $subref)
    {
        $this->registre = $registre;
        $this->ref = $ref;
        $this->subref = $subref;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->registre->subreferencia == $this->subref){
            return true;
        }else {
            $registre = RegistreProduccio::where('id_registre_entrada', $this->ref)
                    ->whereSubreferencia($this->subref)->first();
        
            if ($registre){
                return false;
            }
            return true; 
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No es pot repetir la subreferencia.';
    }
}
