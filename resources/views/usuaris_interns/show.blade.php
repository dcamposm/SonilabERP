@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">Dades personals</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Imatge:</td>
                <td class="col">
                    <img src="data:image/jpg;base64,{{$usuari['imatge_usuari']}}" class="rounded" style="height:100px"/>
                </td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Àlies:</td>
                <td class="col">{{ $usuari['alias_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Nom:</td>
                <td class="col">{{ $usuari['nom_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Cognoms:</td>
                <td class="col">{{ $usuari['cognom1_usuari']}} {{ $usuari['cognom2_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Email:</td>
                <td class="col">{{ $usuari['email_usuari']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Departament:</td>
                <td class="col">{{ $departament['nom_departament']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Data de creació:</td>
                <td class="col">{{ $usuari['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Última data de modificació:</td>
                <td class="col">{{ $usuari['updated_at']}}</td>
            </tr>
        </tbody>
    </table>
</div>

@stop
