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
            'cognom1_usuari'     => 'required|max:35',
            'cognom2_usuari'     => 'max:35',
            'email_usuari'       => 'required|email',
            'alias_usuari'       => 'required|min:4|max:35',
            'contrasenya_usuari' => 'required|min:4|max:15|same:cpass',
            'id_departament'     => 'required',
            'cpass'              => 'required|same:contrasenya_usuari'
        ];
    }
    /*
        *Funcio que retorna els missatges d'error, si algun dels atributs no
        *cumpleixen alguna de les regles que tenen aplicades.
    */
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
