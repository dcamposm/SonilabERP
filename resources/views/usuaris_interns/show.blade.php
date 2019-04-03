@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">DADES PERSONALS</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">IMATGE:</td>
                <td class="col">
                    <img src="data:image/jpg;base64,{{$usuari['imatge_usuari']}}" class="rounded" style="height:100px"/>
                </td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÀLIES:</td>
                <td class="col">{{ $usuari['alias_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NOM:</td>
                <td class="col">{{ $usuari['nom_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">COGNOMS:</td>
                <td class="col">{{ $usuari['cognom1_usuari']}} {{ $usuari['cognom2_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">EMAIL:</td>
                <td class="col">{{ $usuari['email_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DEPARTAMENT:</td>
                <td class="col">{{ $departament['nom_departament']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DATA DE CREACIÓ:</td>
                <td class="col">{{ $usuari['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÚLTIMA DATA DE MODIFICACIÓ:</td>
                <td class="col">{{ $usuari['updated_at']}}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ url('/usuaris/interns/index') }}" class="btn btn-primary col-2">
        <span class="fas fa-angle-double-left"></span>
        TORNAR
    </a>
</div>

@stop
