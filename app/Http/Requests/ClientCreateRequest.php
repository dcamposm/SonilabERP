<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom_client'            => 'required',
            'nif_client'            => 'required',
            'email_client'          => 'required|email',
            'telefon_client'        => 'required',
            'direccio_client'       => 'required',
            'codi_postal_client'    => 'required',
            'ciutat_client'         => 'required',
            'pais_client'           => 'required',
        ];
    }
    
    public function messages() {
        return [
            'required'                 => 'No s\'ha posat el :attribute.',
            'direccio_client.required' => 'No s\'ha posat la :attribute.',
            'ciutat_client.required'   => 'No s\'ha posat la :attribute.',
            'email'                    => 'Aquesta dada té que ser un email.'
        ];
    }
    
    public function attributes() {
        return [
            'nom_client'            => 'nom',
            'nif_client'            => 'nif',
            'email_client'          => 'email',
            'telefon_client'        => 'telèfon',
            'direccio_client'       => 'direcció',
            'codi_postal_client'    => 'codi postal',
            'ciutat_client'         => 'ciutat',
            'pais_client'           => 'pais',
        ];
    }
}
