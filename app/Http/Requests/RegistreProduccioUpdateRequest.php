<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckSubreferenciaUpdate;
use Illuminate\Support\Facades\Route;

class RegistreProduccioUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Route::currentRouteName() == "updateRegistreBasic"){
            return [
                'id_registre_entrada'    => 'required',
                'subreferencia'          => ['required', new CheckSubreferenciaUpdate($prod, request()->input('id_registre_entrada'), request()->input('subreferencia'))],
                'data_entrega'           => 'required',
                'setmana'                => 'required',
                'titol'                  => 'required',
                'estat'                  => 'required',
            ];
        } else if (Route::currentRouteName() == "updateRegisteComanda"){
            return [
                'estadillo'         => 'required',
                'propostes'         => 'required',
                'inserts'           => 'required',
                'vec'               => 'required',
                'data_tecnic_mix'       => 'date',            
            ];
        } else if (Route::currentRouteName() == "updateRegistrePreparacio"){
            return [
                'qc_vo'                 => 'required',
                'qc_me'                 => 'required',
                'qc_mix'                => 'required',
                'ppp'                   => 'required',
                'pps'                   => 'required',
                'ppe'                   => 'required',
            ];
        } else if (Route::currentRouteName() == "updateRegistreConvocatoria"){
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
