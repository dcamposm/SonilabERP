@extends('layouts.app')

@section('content')

<div class="container">
<form method = "POST" action="{{ route('updateRegistreProduccioAll', array('id' => $registreProduccio->id)) }}" enctype="multipart/form-data">
    @csrf
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">REGISTRE DE PRODUCCIÓ</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">REFERENCIA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="id_registre_entrada-S">{{ $registreProduccio['id_registre_entrada']." ".$registreProduccio->registreEntrada->titol}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">SUB-REFERENCIA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="subreferencia-N">{{ $registreProduccio['subreferencia']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA ENTREGA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="data_entrega-D">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">SETMANA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="setmana-N">{{ $registreProduccio['setmana']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÍTOL ORIGINAL:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="titol-T">{{ $registreProduccio['titol']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÍTOL TRADUÏT:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="titol_traduit-T">{{ $registreProduccio['titol_traduit']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC VO:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="qc_vo-S">{{ $registreProduccio['qc_vo'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC M&E:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="qc_me-S">{{ $registreProduccio['qc_me'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPP:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="ppp-S">{{ $registreProduccio['ppp'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TRADUCTOR:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="traductor-S-P">{{ array_key_exists("traductor", $empleats) ? $empleats["traductor"]->nom_empleat.' '.$empleats["traductor"]->cognom1_empleat.' '.$empleats["traductor"]->cognom2_empleat : ''}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA TRADUCTOR:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="data_traductor-D">{{ $registreProduccio['data_traductor']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_traductor'])) }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">AJUSTADOR:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="ajustador-S-P">{{ array_key_exists("ajustador", $empleats) ? $empleats["ajustador"]->nom_empleat.' '.$empleats["ajustador"]->cognom1_empleat.' '.$empleats["ajustador"]->cognom2_empleat : ''}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA AJUSTADOR:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="data_ajustador-D">{{ $registreProduccio['data_ajustador']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_ajustador']))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">LINGÜISTA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="linguista-S-P">{{ array_key_exists("linguista", $empleats) ? $empleats["linguista"]->nom_empleat.' '.$empleats["linguista"]->cognom1_empleat.' '.$empleats["linguista"]->cognom2_empleat : ''}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA LINGÜISTA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="data_linguista-D">{{ $registreProduccio['data_linguista']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_linguista']))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DIRECTOR:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>              
                <td class="col" id="director-S-P">{{ array_key_exists("director", $empleats) ? $empleats["director"]->nom_empleat.' '.$empleats["director"]->cognom1_empleat.' '.$empleats["director"]->cognom2_empleat : ''}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">CASTING:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="casting-S">{{ $registreProduccio['casting'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PROPOSTES:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="propostes-S">{{ $registreProduccio['propostes'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">INSERTS:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="inserts-S">{{ $registreProduccio['inserts']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">CONVOS:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="convos-S">{{ $registreProduccio['convos'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">INICI SALA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="inici_sala-D">{{ $registreProduccio['inici_sala']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['inici_sala']))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPS:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="pps-S">{{ $registreProduccio['pps'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">FINAL SALA:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="final_sala-D">{{ $registreProduccio['final_sala']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['final_sala']))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÉCNIC MIX:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="tecnic_mix-S-P">{{ array_key_exists("tecnic_mix", $empleats) ? $empleats["tecnic_mix"]->nom_empleat.' '.$empleats["tecnic_mix"]->cognom1_empleat.' '.$empleats["tecnic_mix"]->cognom2_empleat : ''}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA TÉCNIC MIX:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="data_tecnic_mix-D">{{ $registreProduccio['data_tecnic_mix']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_tecnic_mix']))}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">RETAKES:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="retakes-S">{{ $registreProduccio['retakes']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC MIX:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="qc_mix-S">{{ $registreProduccio['qc_mix'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPE:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="ppe-S">{{ $registreProduccio['ppe'] == 0 ? '' : 'Fet'}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">ESTAT:</td>
                <td class="col-sm-1 align-middle text-center">
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button>
                @endif
                </td>
                <td class="col" id="estat-S">{{ $registreProduccio['estat']}}</td>
            </tr>     
        </tbody>
    </table>
    <div class="row justify-content-between mb-3">
        <a href="{{ url('/registreProduccio') }}" id="botoTornar" class="btn btn-primary col-2">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
        <button id="botonForm" style="display: none;" type="submit" class="btn btn-success col-2">DESAR <i class="fas fa-save"></i></button>
    </div>
    
    <!-- MODAL TORNAR -->
    <div class="modal fade" id="modalTornar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">No s'ha desat els canvis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">Vols tornar enrere sense desar?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreProduccio(0)">TANCAR</button>
                    <a href="{{ url('/registreProduccio') }}" class="btn btn-danger">
                        <span class="fas fa-angle-double-left"></span>
                        TORNAR SENSE DESAR
                    </a>
                    <button type="submit" class="btn btn-success">DESAR <i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<script>
    //alert(@json($registreProduccio->estat))
    var registre = @json($registreProduccio);
    var empleatsCarrec = @json($empleatsCarrec);
    var empleats = @json($empleats);
    var regEntrada = @json($regEntrades);
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/registreProduccioShow.js') }}"></script>
@stop