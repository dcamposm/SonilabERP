<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleatExternCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom_empleat' => 'required',
            'cognom1_empleat' => 'required',
            //'cognom2_empleat' => 'required',
            'sexe_empleat' => 'required',
            'nacionalitat_empleat' => 'required',
            'email_empleat' => 'required|email',
            'dni_empleat' => 'required|regex:/[0-9A-Z][0-9]{7}[A-Z]/',
            'telefon_empleat' => 'required',
            'direccio_empleat' => 'required',
            'codi_postal_empleat' => array('required','regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'),
            'naixement_empleat' => 'required',
            'nss_empleat' => 'required',
            'iban_empleat' => 'required|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/'
        ];
    }
    
    public function messages() {
        return [
            'required' => 'No s\'ha introduït aquesta dada.',
            'email' => 'Aquesta dada té que ser un email.',
            'regex' => 'No te el format correcte',
        ];
    }
}
