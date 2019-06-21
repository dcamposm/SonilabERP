<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendariCarrecUpdateRequest extends FormRequest
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
            'id_empleat'=>'required|max:35|exists:slb_empleats_externs',
            'num_sala'=>'required|regex:/^[0-9]+$/',
            'data'=>'required|max:35',
            'torn'=>'required|max:3',
        ];
    }
}
