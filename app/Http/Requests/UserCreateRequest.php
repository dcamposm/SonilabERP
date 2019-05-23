<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'cognom1_usuari' => 'required|max:35',
            'cognom2_usuari' => 'max:35',
            'email_usuari' => 'required|email',
            'alias_usuari' => 'required|min:4|max:35',
            'contrasenya_usuari' => 'required|min:4|max:15|same:cpass',
            'id_departament' => 'required',
            'cpass' => 'required|same:contrasenya_usuari'
        ];
    }
    /*
        *Funcio que retorna els missatges d'error, si algun dels atributs no
        *cumpleixen alguna de les regles que tenen aplicades.
    */
    public function messages() {
        return [
            'cognom1_usuari.required' => ' No s\'ha posat el primer cognom.',
            'cognom2_usuari.required' => ' No s\'ha posat el segon cognom.',
            'email_usuari.required' => ' No s\'ha posat el email.', 
            'alias_usuari.required' => ' No s\'ha posat el àlies.',
            'contrasenya_usuari.required' => ' No s\'ha posat la contrasenya.',
            'cpass.required' => ' No s\'ha posat la contrasenya.',
            'id_departament.required' => ' No s\'ha seleccionat un departament.',
            '*.max' => ' El tamany màxim és de :max caracters.',
            '*.min' => ' El tamany mínim és de :min caracters.',
            'same' => 'No coincideixen les contrasenyes'
        ];
    }
}
