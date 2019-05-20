<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cognom1_usuari' => 'required|max:35',
            'cognom2_usuari' => 'required|max:35',
            'email_usuari' => 'required|email',
            'alias_usuari' => 'required|min:4|max:35',
            'contrasenya_usuari' => 'required|min:4|max:15|same:cpass',
            'id_departament' => 'required',
            'cpass' => 'same:contrasenya_usuari'
        ];
    }
    
    public function messages() {
        return [
            'cognom1_usuari.required' => ' No s\'ha posat el primer cognom.',
            'cognom2_usuari.required' => ' No s\'ha posat el segon cognom.',
            'email_usuari.required' => ' No s\'ha posat el email.', 
            'alias_usuari.required' => ' No s\'ha posat el àlies.',
            'contrasenya_usuari.required' => ' No s\'ha posat la contrasenya.',
            'id_departament.required' => ' No s\'ha seleccionat un departament.',
            '*.max' => ' El tamany màxim és de :max caracters.',
            '*.min' => ' El tamany mínim és de :min caracters.',
            'same' => 'No coincideixen les contrasenyes'
        ];
    }
}
