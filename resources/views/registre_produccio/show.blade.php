@extends('layouts.app')

@section('content')

<div class="container">
<form method = "POST" action="{{ route('updateRegistreProduccio', array('id' => $registreProduccio->id)) }}" enctype="multipart/form-data">
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
                <td class="col" id="select" style="display: none;">
                    <select name="id_registre_entrada" id="id_registre_entrada" class="form-control">
                      @foreach ($regEntrades as $key => $entrada) 
                        <option value="{{ $entrada->id_registre_entrada }}" {{$entrada->id_registre_entrada == $registreProduccio->id_registre_entrada ? 'selected' : '' }} >{{ $entrada->id_registre_entrada }} {{ $entrada->titol }}</option>
                      @endforeach
                    </select>
                </td>
                <td class="col" id="id_registre_entrada-T">{{ $registreProduccio['id_registre_entrada']." ".$registreProduccio->registreEntrada->titol}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">SUBREFERENCIA:</td>
                <td class="col" id="subreferencia-T">{{ $registreProduccio['subreferencia']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA ENTREGA:</td>
                <td class="col" id="data_entrega-T">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">SETMANA:</td>
                <td class="col" id="setmana-T">{{ $registreProduccio['setmana']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÍTOL ORIGINAL:</td>
                <td class="col" id="titol-T">{{ $registreProduccio['titol']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÍTOL TRADUÏT:</td>
                <td class="col" id="titol_traduit-T">{{ $registreProduccio['titol_traduit']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC VO:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="qc_vo" id="qc_vo" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->qc_vo ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->qc_vo ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="qc_vo-T">{{ $registreProduccio['qc_vo'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC M&E:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="qc_me" id="qc_me" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->qc_me ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->qc_me ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="qc_me-T">{{ $registreProduccio['qc_me'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPP:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="ppp" id="ppp" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->ppp ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->ppp ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="ppp-T">{{ $registreProduccio['ppp'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TRADUCTOR:</td>
                <td class="col" id="select" style="display: none;">
                  <select name="id_traductor" id="id_traductor" class="form-control">
                    @foreach ($empleatsCarrec as $key => $empleat) 
                        @foreach ($empleat->carrec as $key => $carrec) 
                            @if ($carrec->id_tarifa == 12)
                                <option value="{{ $empleat->id_empleat }}" {{$empleat->id_empleat == (array_key_exists("traductor", $empleats) ? $empleats["traductor"]->id_empleat : '') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                            @endif
                        @endforeach
                    @endforeach
                  </select>
                </td>
                <td class="col" id="traductor">{{ array_key_exists("traductor", $empleats) ? $empleats["traductor"]->nom_empleat.' '.$empleats["traductor"]->cognom1_empleat.' '.$empleats["traductor"]->cognom2_empleat : ''}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA TRADUCTOR:</td>
                <td class="col" id="data_traductor-T">{{ $registreProduccio['data_traductor']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_traductor'])) }}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">AJUSTADOR:</td>
                <td class="col" id="select" style="display: none;">
                  <select name="id_ajustador" id="id_ajustador" class="form-control">
                    @foreach ($empleatsCarrec as $key => $empleat) 
                        @foreach ($empleat->carrec as $key => $carrec) 
                            @if ($carrec->id_tarifa == 13)
                                <option value="{{ $empleat->id_empleat }}" {{$empleat->id_empleat == (array_key_exists("ajustador", $empleats) ? $empleats["ajustador"]->id_empleat : '') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                            @endif
                        @endforeach
                    @endforeach
                  </select>
                </td>
                <td class="col" id="ajustador">{{ array_key_exists("ajustador", $empleats) ? $empleats["ajustador"]->nom_empleat.' '.$empleats["ajustador"]->cognom1_empleat.' '.$empleats["ajustador"]->cognom2_empleat : ''}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA AJUSTADOR:</td>
                <td class="col" id="data_ajustador-T">{{ $registreProduccio['data_ajustador']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_ajustador']))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">LINGÜISTA:</td>
                <td class="col" id="select" style="display: none;">
                  <select name="id_linguista" id="id_linguista" class="form-control">
                    @foreach ($empleatsCarrec as $key => $empleat) 
                        @foreach ($empleat->carrec as $key => $carrec) 
                            @if ($carrec->id_tarifa == 14)
                                <option value="{{ $empleat->id_empleat }}" {{$empleat->id_empleat == (array_key_exists("linguista", $empleats) ? $empleats["linguista"]->id_empleat : '') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                            @endif
                        @endforeach
                    @endforeach
                  </select>
                </td>
                <td class="col" id="linguista-T">{{ array_key_exists("linguista", $empleats) ? $empleats["linguista"]->nom_empleat.' '.$empleats["linguista"]->cognom1_empleat.' '.$empleats["linguista"]->cognom2_empleat : ''}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA LINGÜISTA:</td>
                <td class="col" id="data_linguista-T">{{ $registreProduccio['data_linguista']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_linguista']))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DIRECTOR:</td>
                <td class="col" id="select" style="display: none;">
                  <select name="id_director" id="id_director" class="form-control">
                    @foreach ($empleatsCarrec as $key => $empleat) 
                        @foreach ($empleat->carrec as $key => $carrec) 
                            @if ($carrec->id_tarifa == 1 || $carrec->id_tarifa == 2)
                                <option value="{{ $empleat->id_empleat }}" {{$empleat->id_empleat == (array_key_exists("director", $empleats) ? $empleats["director"]->id_empleat : '') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                                @break
                            @endif
                        @endforeach
                    @endforeach
                  </select>
                </td>
                <td class="col" id="director-T">{{ array_key_exists("director", $empleats) ? $empleats["director"]->nom_empleat.' '.$empleats["director"]->cognom1_empleat.' '.$empleats["director"]->cognom2_empleat : ''}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">CASTING:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="casting" id="casting" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->casting ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->casting ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="casting-T">{{ $registreProduccio['casting'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PROPOSTES:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="propostes" id="propostes" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->propostes ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->propostes ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="propostes-T">{{ $registreProduccio['propostes'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">INSERTS:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="inserts" id="inserts" class="form-control">
                        <option value="No cal fer" {{"No cal fer" == $registreProduccio->inserts ? 'selected' : '' }}>No cal fer</option>
                        <option value="Cal fer" {{"Cal fer" == $registreProduccio->inserts ? 'selected' : '' }}>Cal fer</option>
                        <option value="Fet" {{"Fet" == $registreProduccio->inserts ? 'selected' : '' }}>Fet</option>
                    </select>
                </td>
                <td class="col" id="inserts-T">{{ $registreProduccio['inserts']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">ESTADILLO:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="estadillo" id="estadillo" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->estadillo ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->estadillo ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="estadillo-T">{{ $registreProduccio['estadillo'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">VEC:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="vec" id="vec" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->vec ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->vec ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="vec-T">{{ $registreProduccio['vec'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">CONVOS:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="convos" id="convos" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->convos ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->convos ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="convos-T">{{ $registreProduccio['convos'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">INICI SALA:</td>
                <td class="col" id="inici_sala-T">{{ $registreProduccio['inici_sala']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_tecnic_mix']))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPS:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="pps" id="pps" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->pps ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->pps ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="pps-T">{{ $registreProduccio['pps'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">FINAL SALA:</td>
                <td class="col" id="final_sala-T">{{ $registreProduccio['final_sala']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_tecnic_mix']))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">TÉCNIC MIX:</td>
                <td class="col" id="select" style="display: none;">
                  <select name="id_tecnic_mix" id="id_tecnic_mix" class="form-control">
                    @foreach ($empleatsCarrec as $key => $empleat) 
                        @foreach ($empleat->carrec as $key => $carrec) 
                            @if ($carrec->id_tarifa == 3 || $carrec->id_tarifa == 4)
                                <option value="{{ $empleat->id_empleat }}" {{$empleat->id_empleat == (array_key_exists("tecnic_mix", $empleats) ? $empleats["tecnic_mix"]->id_empleat : '') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                                @break
                            @endif
                        @endforeach
                    @endforeach
                  </select>
                </td>
                <td class="col" id="tecnic_mix-T">{{ array_key_exists("tecnic_mix", $empleats) ? $empleats["tecnic_mix"]->nom_empleat.' '.$empleats["tecnic_mix"]->cognom1_empleat.' '.$empleats["tecnic_mix"]->cognom2_empleat : ''}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">DATA TÉCNIC MIX:</td>
                <td class="col" id="data_tecnic_mix-T">{{ $registreProduccio['data_tecnic_mix']==0 ? '' : date('d/m/Y', strtotime($registreProduccio['data_tecnic_mix']))}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">RETAKES:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="retakes" id="retakes" class="form-control">
                        <option value="No" {{"No" == $registreProduccio->retakes ? 'selected' : '' }}>No</option>
                        <option value="Si" {{"Si" == $registreProduccio->retakes ? 'selected' : '' }}>Sí</option>
                        <option value="Fet" {{"Fet" == $registreProduccio->retakes ? 'selected' : '' }}>Fet</option>
                    </select>
                </td>
                <td class="col" id="retakes-T">{{ $registreProduccio['retakes']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">QC MIX:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="qc_mix" id="qc_mix" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->qc_mix ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->qc_mix ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="qc_mix-T">{{ $registreProduccio['qc_mix'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">PPE:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="ppe" id="ppe" class="form-control">
                        <option value="0" {{"0" == $registreProduccio->ppe ? 'selected' : '' }}></option>
                        <option value="1" {{"1" == $registreProduccio->ppe ? 'selected' : '' }}>FET</option>
                    </select>
                </td>
                <td class="col" id="ppe-T">{{ $registreProduccio['ppe'] == 0 ? '' : 'Fet'}}</td>
                @if (Auth::user()->hasAnyRole(['1', '3', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-2">ESTAT:</td>
                <td class="col" id="select" style="display: none;">
                    <select name="estat" id="estat" class="form-control">
                        <option value="Pendent" {{"Pendent" == $registreProduccio->estat ? 'selected' : '' }}>Pendent</option>
                        <option value="Finalitzada" {{"Finalitzada" == $registreProduccio->estat ? 'selected' : '' }}>Finalitzada</option>
                        <option value="Cancel·lada" {{"Cancel·lada" == $registreProduccio->estat ? 'selected' : '' }}>Cancel·lada</option>
                    </select>
                </td>
                <td class="col" id="estat-T">{{ $registreProduccio['estat']}}</td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td class="col-sm-1 align-middle text-center"><button id="mod" class="btn btn-outline-success btn-sm" type="button"><span class="far fa-edit align-middle text-center" style="margin-right: 0px;"></span></button></td>
                @endif
            </tr>     
        </tbody>
    </table>
    <div class="row justify-content-between">
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary col-2">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
        <button id="botonForm" style="display: none;" type="submit" class="btn btn-success col-2">DESAR <i class="fas fa-save"></i></button>
    </div>
</form>
</div>

<script>
    function formTable(){
        //alert($(this).attr('type'));
        if ($(this).attr('type') == 'button'){
            var content = $(this).parent().prev();
            //alert(content.attr('id'));
            if (content.prev().attr('id') == 'select'){
                content.hide();
                content.prev().show();
            } else if (content.attr('id') == 'data_entrega-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->data_entrega)[0]}}"+'">');
            } else if (content.attr('id') == 'data_traductor-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->data_traductor)[0]}}"+'">');
            } else if (content.attr('id') == 'data_ajustador-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->data_ajustador)[0]}}"+'">');
            } else if (content.attr('id') == 'data_linguista-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->data_linguista)[0]}}"+'">');
            } else if (content.attr('id') == 'inici_sala-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->inici_sala)[0]}}"+'">');
            } else if (content.attr('id') == 'final_sala-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->final_sala)[0]}}"+'">');
            } else if (content.attr('id') == 'data_tecnic_mix-T'){
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="date" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+"{{explode(' ',$registreProduccio->data_tecnic_mix)[0]}}"+'">');
            }
            else {
                var value = content.text();
                content.text('');
                var id = content.attr('id');
                var idArray = id.split("-");
                content.append('<input type="text" name="'+idArray[0]+'" id="'+idArray[0]+'" class="form-control" value="'+value+'">');
            }
            //alert(textArray[0]);
            $('#botonForm').show();
        }
    };
    $('button').click(formTable);
</script>
@stop