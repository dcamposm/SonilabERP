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
            'required' => 'No s\'ha introduït aquesta dada.',
            'email' => 'Aquesta dada té que ser un email.'
        ];
    }
}
