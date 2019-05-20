<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckSubreferenciaCreate;
use Illuminate\Support\Facades\Route;

class RegistreProduccioCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Route::currentRouteName() == "createRegistreBasic"){
            return [
                'id_registre_entrada'    => 'required',
                'subreferencia'          => ['required',new CheckSubreferenciaCreate(request()->input('id_registre_entrada'), request()->input('subreferencia'))],
                'data_entrega'           => 'required',
                'setmana'                => 'required',
                'titol'                  => 'required',
                'estat'                  => 'required',
            ];
        } else if (Route::currentRouteName() == "createRegisteComanda"){
            return [
                'estadillo'             => 'required',
                'propostes'             => 'required',
                'inserts'               => 'required',
                'titol_traduit'         => 'required',
                'vec'                   => 'required',
                'data_tecnic_mix'       => 'date',
            ];
        } else if (Route::currentRouteName() == "createRegistrePreparacio"){
            return [
                'qc_vo'                 => 'required',
                'qc_me'                 => 'required',
                'qc_mix'                => 'required',
                'ppp'                   => 'required',
                'pps'                   => 'required',
                'ppe'                   => 'required',
            ];
        } else if (Route::currentRouteName() == "createRegistreConvocatoria"){
            return [
                'convos'            => 'required',
                'inici_sala'        => 'date',
                'final_sala'        => 'date',
                'retakes'           => 'required',
            ];
        }
        
    }
    
    public function messages() {
        return [
            'required' => 'No s\'ha introduït aquesta dada.',
            'date' => 'Aquesta dada te que ser una data.'
        ];
    }
}
