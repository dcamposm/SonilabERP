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
            'nom_empleat'           => 'required',
            'cognom1_empleat'       => 'required',
            //'cognom2_empleat'     => 'required',
            'sexe_empleat'          => 'required',
            'nacionalitat_empleat'  => 'required',
            'email_empleat'         => 'required|email',
            'dni_empleat'           => 'required|regex:/[0-9A-Z][0-9]{7}[A-Z]/',
            'telefon_empleat'       => 'required',
            'direccio_empleat'      => 'required',
            'codi_postal_empleat'   => array('required','regex:/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'),
            'naixement_empleat'     => 'required',
            'nss_empleat'           => 'required',
            //'iban_empleat'          => 'required|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/'
        ];
    }
    
    public function messages() {
        return [
            'required'                      => 'No s\'ha posat el :attribute.',
            'nacionalitat_empleat.required' => 'No s\'ha posat la :attribute.',
            'direccio_empleat.required'     => 'No s\'ha posat la :attribute.',
            'email'                         => 'Aquesta dada té que ser un email.',
            'regex'                         => 'No te el :attribute format correcte',
        ];
    }
    
    public function attributes() {
        return [
            'nom_empleat'           => 'nom',
            'cognom1_empleat'       => 'primer cognom',
            'sexe_empleat'          => 'sexe',
            'nacionalitat_empleat'  => 'nacionalitat',
            'email_empleat'         => 'email',
            'dni_empleat'           => 'DNI',
            'telefon_empleat'       => 'telèfon',
            'direccio_empleat'      => 'direcció',
            'codi_postal_empleat'   => 'codi postal',
            'naixement_empleat'     => 'data naixement',
            'nss_empleat'           => 'NSS',
            'iban_empleat'          => 'IBAN'
        ];
    }
}
