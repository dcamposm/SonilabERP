@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">Client</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Nom:</td>
                <td class="col">{{ $client['nom_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Email:</td>
                <td class="col">{{ $client['email_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Telefon:</td>
                <td class="col">{{ $client['telefon_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Direcció:</td>
                <td class="col">{{ $client['direccio_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Codi postal:</td>
                <td class="col">{{ $client['codi_postal_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Ciutat:</td>
                <td class="col">{{ $client['ciutat_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Pais:</td>
                <td class="col">{{ $client['pais_client']}}</td>
            </tr>
        </tbody>
    </table>
</div>

@stop