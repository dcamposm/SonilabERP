@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">CLIENT</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NOM:</td>
                <td class="col">{{ $client['nom_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">EMAIL:</td>
                <td class="col">{{ $client['email_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">TELÈFON:</td>
                <td class="col">{{ $client['telefon_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DIRECCIÓ:</td>
                <td class="col">{{ $client['direccio_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">CODI POSTAL:</td>
                <td class="col">{{ $client['codi_postal_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">CIUTAT:</td>
                <td class="col">{{ $client['ciutat_client']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">PAIS:</td>
                <td class="col">{{ $client['pais_client']}}</td>
            </tr>
        </tbody>
    </table>
    
    <div>
        <a href="{{ url('/clients') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
    </div>
</div>

@stop