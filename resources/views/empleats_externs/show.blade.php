@extends('layouts.app')

@section('content')

<!-- TODO: Hacer que las tablas puedan ocultar sus "tbody" para que el usuario desplegue el que desee -->

<div class="container">
    <a href="{{ url('/empleats') }}" class="btn btn-primary col-2">
        <span class="fas fa-angle-double-left"></span>
        TORNAR ENRERA
    </a>
    <br>
    <br>
    <!-- DATOS PERSONALES DEL EMPLEADO -->
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
                    <img src="data:image/jpg;base64,{{$empleat['imatge_empleat']}}" class="rounded" style="height:100px"/>
                </td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NOM:</td>
                <td class="col">{{ $empleat['nom_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">COGNOMS:</td>
                <td class="col">{{ $empleat['cognom1_empleat']}} {{ $empleat['cognom2_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">SEXE:</td>
                <td class="col">{{ $empleat['sexe_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NACIONALITAT:</td>
                <td class="col">{{ $empleat['nacionalitat_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">E-MAIL:</td>
                <td class="col">{{ $empleat['email_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DNI:</td>
                <td class="col">{{ $empleat['dni_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">TELÈFON:</td>
                <td class="col">{{ $empleat['telefon_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DIRECCIÓ:</td>
                <td class="col">{{ $empleat['direccio_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">CODI POSTAL:</td>
                <td class="col">{{ $empleat['codi_postal_empleat']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">NAIXEMENT:</td>
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
                <td class="font-weight-bold col-sm-3">DATA DE CREACIÓ:</td>
                <td class="col">{{ $empleat['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÚLTIMA MODIFICACIÓ:</td>
                <td class="col">{{ $empleat['updated_at']}}</td>
            </tr>
        </tbody>
    </table>

    <!-- CARGOS DEL EMPLEADO -->
    <div class="row">
        @foreach( $carrecsEmpelat as $key => $carrec )
        
        <div class="{{(Auth::user()->hasAnyRole(['1', '4'])) ? 'col-12' : 'col-6 col-sm-6 col-md-3'  }}">
            <table class="table">
                <thead class="thead-dark" style="border-left: 3px solid white">
                    <tr class="row">
                        <th class="col">{{ $key != 'Traductor' ? 'TARIFA '.strtr(strtoupper($key), "àáèéíóúüç", "ÀÁÈÉÍÓÚÜÇ") : 'TARIFA TRADUCTOR/AJUSTADOR/LINGÜISTA' }}</th>
                        <th class="col">{{ $carrec['contracta'] == 0 ? 'FACTURA' : 'ALTA I BAIXA'}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $carrec as $key2 => $info )
                        @if ($key2 === 0)     
                            @if(Auth::user()->hasRole('1') OR Auth::user()->hasRole('4'))
                            <tr class="row">
                                @foreach ($info as $key => $tarifa) 
                                    <td class="col">{{ strtr(strtoupper($tarifa['tarifa']), "àáèéíóúüç", "ÀÁÈÉÍÓÚÜÇ") }}</td>
                                @endforeach
                            </tr>
                            
                                <tr class="row">
                                    @foreach ($info as $key => $tarifa) 
                                        <td class="col">{{ $tarifa['preu_carrec'] }}€</td>
                                    @endforeach
                                </tr>  
                            @endif
                        @elseif ($key2 !== 'contracta')
                            <tr class="row table-active">
                                <td class="col"><img src="{{url('/')}}/img/flags/{{$key2}}.png" class="rounded"> {{ strtr(strtoupper($key2), "àáèéíóúüç", "ÀÁÈÉÍÓÚÜÇ") }}</td>                   
                                <td class="col">
                                @foreach ($info as $key3 => $tarifa) 
                                    @if ($tarifa['empleat_homologat'] == '1')
                                        HOMOLOGAT
                                        @break
                                    @endif
                                @endforeach
                                </td>
                                <td class="col">
                                @foreach ($info as $key3 => $tarifa) 
                                    @if ($tarifa['rotllo'] == '1')
                                        Rotllo
                                        @break
                                    @endif
                                @endforeach
                                </td>
                            </tr>
                            @if(Auth::user()->hasAnyRole(['1', '4']))
                                <tr class="row text-center bg-white">
                                    @foreach ($info as $key => $infoTarifa) 
                                        @if ($infoTarifa['nomCarrec'] == 'Actor')
                                            @foreach( $tarifas as $key3 => $tarifa)
                                                @if($tarifa->id_carrec == 1)
                                                    <td class="col">{{strtr(strtoupper($tarifa->nombre), "àáèéíóúüç", "ÀÁÈÉÍÓÚÜÇ")}}</td>
                                                @endif
                                            @endforeach
                                        @break
                                        @else
                                            @foreach( $tarifas as $key3 => $tarifa)
                                                @if($tarifa->id_carrec == 4 )
                                                    <td class="col text-left">{{strtr(strtoupper($tarifa->nombre), "àáèéíóúüç", "ÀÁÈÉÍÓÚÜÇ")}}</td>
                                                @endif
                                            @endforeach
                                        @break
                                        @endif
                                    @endforeach
                                </tr>

                                <tr class="row text-center bg-white">
                                    @foreach ($info as $key => $infoTarifa) 
                                        @if ($infoTarifa['nomCarrec'] == 'Actor')
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa video take')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa)
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa video cg')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa cine take')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa)
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa cine cg')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa canço')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa docu')
                                                        <{{ $infoTarifa['preu_carrec'] }}
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td class="col">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa narrador')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td> 
                                            @break
                                        @else
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa traductor')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa ajustador')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa lingüista')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa sinopsi')
                                                        {{ $infoTarifa['preu_carrec'] }}€
                                                    @endif
                                                @endforeach
                                            </td>
                                            @break
                                        @endif
                                    @endforeach
                                </tr>
                            @else
                                <tr class="row bg-white">
                                    @foreach ($info as $key => $infoTarifa) 
                                        @if ($infoTarifa['nomCarrec'] == 'Traductor')
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa traductor')
                                                        Traductor
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa ajustador')
                                                        Ajustador
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="col text-left">
                                                @foreach ($info as $key2 => $infoTarifa) 
                                                    @if ($infoTarifa['tarifa'] == 'Tarifa lingüista')
                                                        Lingüista
                                                    @endif
                                                @endforeach
                                            </td>
                                            @break
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</div>

@stop
