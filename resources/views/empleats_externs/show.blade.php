@extends('layouts.app')

@section('content')

<!-- TODO: Hacer que las tablas puedan ocultar sus "tbody" para que el usuario desplegue el que desee -->

<div class="container">
    <!-- DATOS PERSONALES DEL EMPLEADO -->
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
                    <img src="data:image/jpg;base64,{{$empleat['imatge_empleat']}}" class="rounded" style="height:100px"/>
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
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Data de creació:</td>
                <td class="col">{{ $empleat['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">Última data de modificació:</td>
                <td class="col">{{ $empleat['updated_at']}}</td>
            </tr>
        </tbody>
    </table>

    <!-- CARGOS DEL EMPLEADO -->
    <div class="row container">
        @foreach( $carrecsEmpelat as $key => $carrec )
        <div style="width: 100%; margin-left: 15px; display:block">
            <div class="form-group">
                <table class="table">
                    <thead class="thead-dark">
                        <tr class="row">
                            <th class="col">{{ $key }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach( $carrec as $key => $info)
                        
                        @if (empty($info['idioma']))
                        <tr class="row">
                            <td class="col">
                                {{ $info['id_carrec'] == 2 ? 'Preu Rotllo: ' : 'Tarifa sala: '}}{{ $info['preu_carrec1'] }}€
                            </td>
                            <td class="col">
                                {{ $info['id_carrec' ]== 2 ? 'Preu Minut: ' : 'Tarifa MIX: '}}{{ $info['preu_carrec2'] }}€
                            </td>
                        </tr>    
                        @else
                            @if ($info['id_carrec'] == 1)
                            <tr class="row">
                                <td class="col">
                                    <img src="{{url('/')}}/img/flags/{{$info['id_idioma']}}.png" class="rounded"> {{ $info['idioma'] }}                                    
                                </td>
                                <td class="col">
                                    {{ $info['empleat_homologat'] ? 'Homologat' : 'No homologat' }}
                                </td>
                            </tr>
                            <tr class="row">                                
                                <td class="col">
                                    <b>Video CG's:</b> {{ empty($info['preu_video_tk']) ? '-' : $info['preu_video_tk'].'€' }}
                                </td>
                                </td>
                                <td class="col">
                                    <b>Video TK's:</b> {{ empty($info['preu_video_cg']) ? '-' : $info['preu_video_cg'].'€' }}
                                </td>
                                <td class="col">
                                    <b>Cine CG's:</b> {{ empty($info['preu_cine_tk']) ? '-' : $info['preu_cine_tk'].'€' }}
                                </td>
                                </td>
                                <td class="col">
                                    <b>Cine TK's:</b> {{ empty($info['preu_cine_cg']) ? '-' : $info['preu_cine_cg'].'€' }}
                                </td>
                                <td class="col">
                                    <b>Documental:</b> {{ empty($info['preu_docu']) ? '-' : '<'.$info['preu_docu'] }}
                                </td>
                                </td>
                                <td class="col">
                                    <b>Narrador:</b> {{ empty($info['preu_carrec1']) ? '-' : $info['preu_carrec1'].'€' }}
                                </td>
                                <td class="col">
                                    <b>Cançons:</b> {{ empty($info['preu_carrec2']) ? '-' : $info['preu_carrec2'].'€' }}
                                </td>
                            </tr>
                            @else
                            <tr class="row">
                                <td class="col">
                                    <img src="{{url('/')}}/img/flags/{{$info['id_idioma']}}.png" class="rounded"> {{ $info['idioma'] }}
                                </td>
                            </tr>
                            <tr class="row">
                                <td class="col">
                                    {{ $info['empleat_homologat'] ? 'Homologat' : 'No homologat' }}
                                </td>
                                <td class="col">
                                    {{ $info['preu_carrec1'] }}€
                                </td>
                                <td class="col">
                                    {{ $info['preu_carrec2'] }}€
                                </td>
                            </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody> 
                </table>
            </div>
        </div>
        @endforeach
    </div>
    <!--
    <div class="row">
        @foreach( $carrecsEmpelat as $key => $carrec )
        <div class="col-6 col-sm-6 col-md-4">
            <table class="table">
                <thead class="thead-dark" style="border-left: 3px solid white">
                    <tr class="row">
                        <th class="col">{{ $key }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $carrec as $key => $info )
                        @if (empty($info['idioma']))
                            <tr class="row">
                                <td class="col">{{ $info['preu_carrec1'] }}€</td>
                            </tr>
                        @else
                            <tr class="row">
                                <td class="col"><img src="{{url('/')}}/img/flags/{{$info['id_idioma']}}.png" class="rounded"> {{ $info['idioma'] }}</td>
                                <td class="col">{{ $info['empleat_homologat'] ? 'Homologat' : 'No homologat' }}</td>
                                <td class="col">{{ $info['preu_carrec1'] }}€</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>
    -->

@stop
