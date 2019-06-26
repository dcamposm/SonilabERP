@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">REGISTRES D'ENTRADA</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_registre_entrada']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">REFERÈNCIA:</td>
                <td class="col">{{ $registreEntrada->id_registre_entrada}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['titol']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">TÍTOL:</td>
                <td class="col">{{ $registreEntrada->titol}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['ot']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">OT:</td>
                <td class="col">{{ $registreEntrada->ot}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['OC']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">OC:</td>
                <td class="col">{{ $registreEntrada->OC}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['sortida']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">PRIMERA ENTREGA:</td>
                <td class="col">{{ date('d-m-Y', strtotime($registreEntrada->sortida))}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_usuari']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">RESPONSABLE:</td>
                <td class="col">{{ isset($registreEntrada->usuari) ? $registreEntrada->usuari->nom_cognom :  '' }}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_client']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">CLIENT:</td>
                <td class="col">{{ $registreEntrada->client->nom_client }}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_servei']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">SERVEI:</td>
                <td class="col">{{ $registreEntrada->servei->nom_servei}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_idioma']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">IDIOMA:</td>
                <td class="col">{{ $registreEntrada->idioma->idioma}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['id_media']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">TIPUS:</td>
                <td class="col">{{ $registreEntrada->media->nom_media}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['minuts']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">MINUTS TOTALS:</td>
                <td class="col">{{ $registreEntrada->minuts}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['total_episodis']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">NÚMERO D'EPISODIS:</td>
                <td class="col">{{ $registreEntrada->total_episodis}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['episodis_setmanals']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">EPISODIS SETMANALS:</td>
                <td class="col">{{ $registreEntrada->episodis_setmanals}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['entregues_setmanals']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">ENTREGUES SETMANALS:</td>
                <td class="col">{{ $registreEntrada->entregues_setmanals}}</td>
            </tr>
            <tr class="row" style='{{ $missatges != null ? (isset($missatges['estat']) ? " background-color: lawngreen;" : "") : ""}}'>
                <td class="font-weight-bold col-sm-3">ESTAT:</td>
                <td class="col">{{ $registreEntrada->estat}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DATA DE CREACIÓ:</td>
                <td class="col">{{ $registreEntrada['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÚLTIMA ACTUALITZACIÓ:</td>
                <td class="col">{{ $registreEntrada->updated_at}}</td>
            </tr>
        </tbody>
    </table>
    
    <a href="{{ url('/registreEntrada') }}" class="btn btn-primary col-2 mb-3">
        <span class="fas fa-angle-double-left"></span>
        TORNAR
    </a>
</div>

@stop