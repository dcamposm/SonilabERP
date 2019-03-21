@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">Registre d'Entrada</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Títol:</td>
                <td class="col">{{ $registreEntrada['titol']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">OT:</td>
                <td class="col">{{ $registreEntrada['ot']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">OC:</td>
                <td class="col">{{ $registreEntrada['OC']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Entrada:</td>
                <td class="col">{{ $registreEntrada['entrada']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Sortida:</td>
                <td class="col">{{ $registreEntrada['sortida']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Client:</td>
                <td class="col">{{ $client['nom_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Servei:</td>
                <td class="col">{{ $servei['nom_servei']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Idioma:</td>
                <td class="col">{{ $idioma['idioma']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Tipus:</td>
                <td class="col">{{ $media['nom_media']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Minuts:</td>
                <td class="col">{{ $registreEntrada['minuts']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Número d'episodis:</td>
                <td class="col">{{ $registreEntrada['total_episodis']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Episodis setmanals:</td>
                <td class="col">{{ $registreEntrada['episodis_setmanals']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Entregues setmanals:</td>
                <td class="col">{{ $registreEntrada['entregues_setmanals']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Estat:</td>
                <td class="col">{{ $registreEntrada['estat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Data de creació:</td>
                <td class="col">{{ $registreEntrada['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Última actualització:</td>
                <td class="col">{{ $registreEntrada['updated_at']}}</td>
            </tr>
        </tbody>
    </table>
</div>

@stop