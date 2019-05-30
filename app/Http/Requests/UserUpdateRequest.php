<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cognom1_usuari'    => 'required|max:35',
            'cognom2_usuari'    => 'required|max:35',
            'email_usuari'      => 'required|email',
            'alias_usuari'      => 'required|min:4|max:35',
            //'contrasenya_usuari' => 'required|min:4|max:15',
            'id_departament'    => 'required'
        ];
    }
    
    public function messages() {
        return [
            'required'  => ' No s\'ha posat el :attribute.',
            '*.max'     => ' El :attribute no pot superar un tamany màxim de :max caracters.',
            '*.min'     => ' El :attribute no pot  tamany mínim és de :min caracters.',
            'same'      => 'No coincideixen les contrasenyes.'
        ];
    }
    
    public function attributes() {
        return [
            'alias_usuari'       => 'nom',
            'cognom1_usuari'     => 'primer cognom',
            'cognom2_usuari'     => 'segon cognom',
            'email_usuari'       => 'email',
            'contrasenya_usuari' => 'contrasenya',
            'id_departament'     => 'departament',
            'cpass'              => 'confirma contrasenya'
        ];
    }
}
