@extends('layouts.app')

@section('content')

<!-- TODO: Hacer que las tablas puedan ocultar sus "tbody" para que el usuario desplegue el que desee -->

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">Dades personals</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Image:</td>
                <td class="col">
                    <img src="{{url('/')}}/img/usuaris/{{$empleat['imatge_empleat']}}" class="rounded" style="height:100px"/>
                </td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Nom:</td>
                <td class="col">{{ $empleat['nom_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Cognoms:</td>
                <td class="col">{{ $empleat['cognoms_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Sexe:</td>
                <td class="col">{{ $empleat['sexe_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Nacionalitat:</td>
                <td class="col">{{ $empleat['nacionalitat_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">E-mail:</td>
                <td class="col">{{ $empleat['email_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DNI:</td>
                <td class="col">{{ $empleat['dni_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Telèfon:</td>
                <td class="col">{{ $empleat['telefon_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Direcció:</td>
                <td class="col">{{ $empleat['direccio_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Codi postal:</td>
                <td class="col">{{ $empleat['codi_postal_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Naixement:</td>
                <td class="col">{{ $empleat['naixement_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NSS:</td>
                <td class="col">{{ $empleat['nss_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">IBAN:</td>
                <td class="col">{{ $empleat['iban_empleat']}}</td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        @foreach( $idiomesEmpleat as $key => $idiomaEmpleat )
        <div class="col-6 col-sm-6 col-md-4">
            <table class="table table-striped">
                @if ($idiomaEmpleat['preu_actor'] > 0)
                <thead class="thead-dark">
                    <tr class="row">
                        <th class="col">Actor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Idioma:</td>
                        <td class="col">{{ $idiomes[$idiomaEmpleat['id_idioma']]->idioma }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Homologat:</td>
                        <td class="col">{{ ($idiomaEmpleat['empleat_homologat']) ? 'Sí' : 'No' }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Preu:</td>
                        <td class="col">{{ $idiomaEmpleat['preu_actor'] }}</td>
                    </tr>
                </tbody>
                @elseif ($idiomaEmpleat['preu_traductor'] > 0)
                <thead class="thead-dark">
                    <tr class="row">
                        <th class="col">Traductor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Idioma:</td>
                        <td class="col">{{ $idiomes[$idiomaEmpleat['id_idioma']]->idioma }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Homologat:</td>
                        <td class="col">{{ ($idiomaEmpleat['empleat_homologat']) ? 'Sí' : 'No' }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Preu:</td>
                        <td class="col">{{ $idiomaEmpleat['preu_traductor'] }}</td>
                    </tr>
                </tbody>
                @elseif ($idiomaEmpleat['preu_linguista'] > 0)
                <thead class="thead-dark">
                    <tr class="row">
                        <th class="col">Linguista</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Idioma:</td>
                        <td class="col">{{ $idiomes[$idiomaEmpleat['id_idioma']]->idioma }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Homologat:</td>
                        <td class="col">{{ ($idiomaEmpleat['empleat_homologat']) ? 'Sí' : 'No' }}</td>
                    </tr>
                    <tr class="row">
                        <td class="font-weight-bold col-sm-3">Preu:</td>
                        <td class="col">{{ $idiomaEmpleat['preu_linguista'] }}</td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
        @endforeach
    </div>
    
    
</div>


@stop
