<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalednariCreateDiaFestiuRequest extends FormRequest
{
    /*
        *Classe FormRequest encarregada de validar les dades introduides de 
        *la vista create d'usuaris interns.
    */
    public function authorize()
    {
        return true;
    }
    /*
        *Funcio que aplica les regles de validació als atributs
    */
    public function rules()
    {
        return [
            'diaInici'=>'required'
        ];
    }
}
