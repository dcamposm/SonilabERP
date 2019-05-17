<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistreEntradaCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titol'      => 'required',
            'sortida'    => 'required',
            'id_usuari'  => 'required',
            'id_client'  => 'required',
            'id_servei'  => 'required',
            'id_idioma'  => 'required',
            'id_media'   => 'required',
            'minuts'     => 'required',
            'estat'      => 'required',
        ];
    }
    
    public function messages() {
        return [
            'titol.required'      => 'El :attribute no s\'ha introduït.',
            'sortida.required'    => 'La :attribute no s\'ha introduït.',
            'id_usuari.required'  => 'El :attribute no s\'ha introduït.',
            'id_client.required'  => 'El :attribute no s\'ha introduït.',
            'id_servei.required'  => 'El :attribute no s\'ha introduït.',
            'id_idioma.required'  => 'El :attribute no s\'ha introduït.',
            'id_media.required'   => 'El :attribute no s\'ha introduït.',
            'minuts.required'     => 'Els :attribute no s\'ha introduït.',
            'estat.required'      => 'El :attribute no s\'ha introduït.',
        ];
    }
    
    public function attributes() {
        return [
            'titol'      => 'títol',
            'sortida'    => 'data de la primera entrega',
            'id_usuari'  => 'responsable',
            'id_client'  => 'client',
            'id_servei'  => 'servei',
            'id_idioma'  => 'idioma',
            'id_media'   => 'tipus',
            'minuts'     => 'minuts totals',
            'estat'      => 'estat',
        ];
    }
}
