@extends('layouts.app')

@section('content')

<div class="container-fluid">
    @if (Auth::user()->hasAnyRole(['3']))
    <div class="row justify-content-end">
    @else
    <div class="row">
    @endif
        @if(Auth::user()->hasAnyRole(['1','2','4']))
        <div class="col">
            <a href="{{ url('/registreProduccio/crear') }}" class="btn btn-success m-1">
                <span class="fas fa-atlas"></span>
                AFEGIR REGISTRE DE PRODUCCIÓ
            </a>
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <a href="{{ url('/estadillos') }}" class="btn btn-success m-1">
                <span class="fas fa-clipboard-list"></span>
                ESTADILLOS
            </a>
            @endif
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <a href="{{ url('/vec') }}" class="btn btn-success m-1">
                <i class="fas fa-calculator"></i>
                VEC
            </a>
            @endif
        </div>
        @endif
        <!-- FILTRA REGISTRE PRODUCCIO -->
        <div class="row m-1">
            <div class="col">
                <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                    @csrf
                    <div class="input-group">
                        <select class="custom-select" id='searchBy' name="searchBy" form="search">
                            <option value="id_registre_entrada" selected>BUSCAR PER...</option>
                            <option value="id_registre_entrada">REFERÈNCIA</option>
                            <option value="titol">TÍTOL</option>
                            <option value="subreferencia">SUB-REFERÈNCIA</option>
                            <option value="data_entrega" id="date">DATA D'ENTREGA</option>
                            <option value="estat" id="estat">ESTAT</option>
                            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                                @if (Auth::user()->hasAnyRole(['2']))
                                    <option value="titol_traduit">TÍTOL TRADUIT</option>
                                    <option value="id_traductor">TRADUCTOR</option>
                                    <option value="data_traductor" id="date">DATA TRADUTOR</option>
                                    <option value="id_ajustador">AJUSTADOR</option>
                                    <option value="data_ajustador" id="date">DATA AJUSTADOR</option>
                                    <option value="id_linguista">LINGÜISTA</option>
                                    <option value="data_linguista" id="date">DATA LINGÜISTA</option>
                                    <option value="id_director">DIRECTOR</option>
                                    <option value="casting" id="fet">CÀSTING</option>
                                    <option value="propostes" id="fet">PROPOSTES</option>
                                    <option value="inserts" id="inserts">INSERTS</option>
                                    <option value="convos" id="fet">CONVOS</option>
                                    <option value="inici_sala" id="date">INICI SALA</option>
                                    <option value="final_sala" id="date">FINAL SALA</option>
                                    <option value="data_tecnic_mix" id="date">DATA MIX</option>
                                    <option value="retakes" id="retakes">RETAKES</option>
                                @endif
                                <option value="estadillo" id="fet">ESTADILLO</option>
                                <option value="vec" id="fet">VEC</option>
                            @elseif (Auth::user()->hasAnyRole(['3']))
                                <option value="qc_vo" id="fet">QC VO</option>
                                <option value="qc_me" id="fet">QC M&E</option>
                                <option value="ppp" id="fet">PPP</option>
                                <option value="pps" id="fet">PPS</option>
                                <option value="id_tecnic_mix">TÈCNIC MIX</option>
                                <option value="data_tecnic_mix" id="date">DATA MIX</option>
                                <option value="qc_mix" id="fet">QC MIX</option>
                                <option value="ppe" id="fet">PPE</option>
                                <option value="retakes" id="retakes">RETAKES</option>
                            @endif
                        </select>
                        
                        <select class="custom-select" id='orderBy' name="orderBy" form="search">
                            <option value="id_registre_entrada" selected>ORDENAR PER...</option>
                            <option value="id_registre_entrada">REFERÈNCIA</option>
                            <option value="titol">TÍTOL</option>
                            <option value="subreferencia">SUB-REFERÈNCIA</option>
                            <option value="data_entrega" id="date">DATA D'ENTREGA</option>
                            <option value="estat" id="estat">ESTAT</option>
                            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                                @if (Auth::user()->hasAnyRole(['2']))
                                    <option value="titol_traduit">TÍTOL TRADUIT</option>
                                    <option value="id_traductor">TRADUCTOR</option>
                                    <option value="data_traductor" id="date">DATA TRADUTOR</option>
                                    <option value="id_ajustador">AJUSTADOR</option>
                                    <option value="data_ajustador" id="date">DATA AJUSTADOR</option>
                                    <option value="id_linguista">LINGÜISTA</option>
                                    <option value="data_linguista" id="date">DATA LINGÜISTA</option>
                                    <option value="id_director">DIRECTOR</option>
                                    <option value="casting" id="fet">CÀSTING</option>
                                    <option value="propostes" id="fet">PROPOSTES</option>
                                    <option value="inserts" id="inserts">INSERTS</option>
                                    <option value="convos" id="fet">CONVOS</option>
                                    <option value="inici_sala" id="date">INICI SALA</option>
                                    <option value="final_sala" id="date">FINAL SALA</option>
                                    <option value="data_tecnic_mix" id="date">DATA MIX</option>
                                    <option value="retakes" id="retakes">RETAKES</option>
                                @endif
                                <option value="estadillo" id="fet">ESTADILLO</option>
                                <option value="vec" id="fet">VEC</option>
                            @elseif (Auth::user()->hasAnyRole(['3']))
                                <option value="qc_vo" id="fet">QC VO</option>
                                <option value="qc_me" id="fet">QC M&E</option>
                                <option value="ppp" id="fet">PPP</option>
                                <option value="pps" id="fet">PPS</option>
                                <option value="id_tecnic_mix">TÈCNIC MIX</option>
                                <option value="data_tecnic_mix" id="date">DATA MIX</option>
                                <option value="qc_mix" id="fet">QC MIX</option>
                                <option value="ppe" id="fet">PPE</option>
                                <option value="retakes" id="retakes">RETAKES</option>
                            @endif
                        </select>
                        <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar per...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div class="d-flex justify-content-end" style="margin-top: 10px;">
        <div class="llegenda">
            <span style="color: lawngreen; font-size: 15px;">&#9646;</span>
            <span style="font-size: 11px; padding: 1px;">FINALITZAT</span>
        </div>
        <div class="llegenda">
            <span style="color: darkorange; font-size: 15px;">&#9646;</span>
            <span style="font-size: 11px; padding: 1px;">PENDENT</span>
        </div>
        <div class="llegenda">
            <span style="color: deepskyblue ; font-size: 15px;">&#9646;</span>
            <span style="font-size: 11px; padding: 1px;">AGRUPACIÓ</span>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table" id="parentTable" style="margin-top: 10px;  min-width: 1200px; font-size: 10px; border-collapse:collapse;">
        <thead>
            <tr>
                <th>REF.</th> 
                <th>SUB-REF</th> 
                <th>DATA D'ENTREGA</th>
                <th>SETMANA</th>
                <th>TÍTOL ORIGINAL</th>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    @if (Auth::user()->hasAnyRole(['2']))
                        <th>TÍTOL TRADUIT</th>
                        <th>TRADUCTOR</th>
                        <th>DATA TRADUCTOR</th>
                        <th>AJUSTADOR</th>
                        <th>DATA AJUSTADOR</th>
                        <th>LINGÜISTA</th>
                        <th>DATA LINGÜISTA</th>
                        <th>DIRECTOR</th>
                        <th>CÀSTING</th>
                        <th>PROPOSTES</th>
                        <th>INSERTS</th>
                        <th>ESTADILLO</th>
                        <th>VEC</th>
                        <th>CONVOS</th>
                        <th>INICI SALA</th>
                        <th>FINAL SALA</th>
                        <th>DATA MIX</th>
                        <th>RETAKES</th>
                    @else
                        <th>ESTADILLO</th>
                        <th>VEC</th>
                    @endif
                    
                @elseif (Auth::user()->hasAnyRole(['3']))
                    <th>QC VO</th>
                    <th>QC M&E</th>
                    <th>PPP</th>
                    <th>PPS</th>
                    <th>TÈCNIC MIX</th>
                    <th>DATA MIX</th>
                    <th>QC MIX</th>
                    <th>PPE</th>
                    <th>RETAKES</th>
                @endif
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody class="panel">
            @foreach( $registreProduccions as $key => $registreProduccio )
                @if (isset($registreProduccio->id))
                    <tr class="table-selected {{ ($registreProduccio->estat == 'Pendent') ? 'border-warning' : (($registreProduccio->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                        <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $registreProduccio->id_registre_entrada)) }}')">
                            <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->id_registre_entrada }}</span>    
                        </td>
                        <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}')">
                            <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->subreferencia }}</span>
                        </td>
                        <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega)) }}</td>
                        <td style="vertical-align: middle;">{{$registreProduccio->setmana}}</td>
                        <td style="vertical-align: middle;">{{$registreProduccio->titol}}</td>
                        @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                            @if (Auth::user()->hasAnyRole(['2']))
                                <td style="vertical-align: middle;">{{ $registreProduccio->titol_traduit }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->traductor ? $registreProduccio->traductor->nom_empleat : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->data_traductor != 0 ? date('d/m/Y', strtotime($registreProduccio->data_traductor)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->ajustador ? $registreProduccio->ajustador->nom_empleat : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->data_ajustador != 0 ? date('d/m/Y', strtotime($registreProduccio->data_ajustador)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->linguista ? $registreProduccio->linguista->nom_empleat : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->data_linguista != 0 ? date('d/m/Y', strtotime($registreProduccio->data_linguista)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->director ? $registreProduccio->director->nom_empleat : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->casting == 0 ? '' : 'FET' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->propostes == 0 ? '' : 'FET' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->inserts }}</td>
                                <td style="vertical-align: middle;">
                                    @if (empty($registreProduccio->getEstadillo))
                                        <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#importModal">IMPORTAR</button>
                                    @else
                                        <a href="{{ route('estadilloShow', array('id' => $registreProduccio->getEstadillo->id_estadillo )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($registreProduccio->vec != 1 || empty($registreProduccio->getVec))
                                        <a href="{{ route('vecGenerar', array('id' => $registreProduccio->id)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">GENERAR</a>
                                    @else
                                        <a href="{{ route('mostrarVec', array('id' => $registreProduccio->getVec->id_costos)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->convos == 0 ? '' : 'FET' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->inici_sala != 0 ? date('d/m/Y', strtotime($registreProduccio->inici_sala)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->final_sala != 0 ? date('d/m/Y', strtotime($registreProduccio->final_sala)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->data_tecnic_mix != 0 ? date('d/m/Y', strtotime($registreProduccio->data_tecnic_mix)) : '' }}</td>
                                <td style="vertical-align: middle;">{{ $registreProduccio->retakes }}</td>
                            @else
                                <td style="vertical-align: middle;">
                                    @if (empty($registreProduccio->getEstadillo))
                                        <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#importModal">IMPORTAR</button>
                                    @else
                                        <a href="{{ route('estadilloShow', array('id' => $registreProduccio->getEstadillo->id_estadillo )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($registreProduccio->vec != 1  || empty($registreProduccio->getVec))
                                        <a href="{{ route('vecGenerar', array('id' => $registreProduccio->id)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">GENERAR</a>
                                    @else
                                        <a href="{{ route('mostrarVec', array('id' => $registreProduccio->getVec->id_costos)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                    @endif
                                </td>
                            @endif
                        @endif
                        @if (Auth::user()->hasAnyRole(['3']))
                            <td style="vertical-align: middle;">{{ $registreProduccio->qc_vo == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->qc_me == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->qc_mix == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->ppp == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->pps == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->ppe == 0 ? '' : 'FET' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->tecnic ? $registreProduccio->tecnic->nom_empleat : '' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->data_tecnic_mix != 0 ? date('d/m/Y', strtotime($registreProduccio->data_tecnic_mix)) : '' }}</td>
                            <td style="vertical-align: middle;">{{ $registreProduccio->retakes }}</td>
                        @endif
                        <td style="vertical-align: middle;">
                            <a href="{{ route('updateRegistreProduccio', array('id' => $registreProduccio->id )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">MODIFICAR</a>
                            @if (Auth::user()->hasAnyRole(['4']))
                                <button class="btn btn-danger btn-sm" style="font-size: 11px;" onclick="self.seleccionarRegistreProduccio({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                                <form id="delete-{{ $registreProduccio->id }}" action="{{ route('deleteRegistre') }}" method="POST">
                                    @csrf
                                    <input type="hidden" readonly name="id" value="{{ $registreProduccio->id }}">
                                </form>
                            @endif
                        </td>
                    </tr>
                @else
                    <!-- ----------------REGISTRES DE SERIES I DPOCUMENTALS------------------------- -->
                    @foreach( $registreProduccio as $key1 => $serie )
                        @if ($key1 == 0)
                            <tr class="table-selected border-primary" id="parent{{$key}}">
                                <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $serie["id_registre_entrada"])) }}')">
                                    <span class="font-weight-bold" style="font-size: 11px;">{{ $serie["id_registre_entrada"] }}</span>    
                                </td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"> </td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"> </td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"> </td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}">{{ $serie['titol'] }}</td>
                                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                                    @if (Auth::user()->hasAnyRole(['2']))
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;">
                                            <form action="{{ route('estadilloFind') }}" method="GET">
                                                @csrf
                                                <input type="hidden" readonly name="search_term" value="{{ $serie['id_registre_entrada'] }}">
                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" type="submit">ESTADILLO</button>
                                            </form>
                                        </td>
                                        <td style="vertical-align: middle;"><a href="{{ route('indexVec', array('ref' => $serie['id_registre_entrada'])) }}" class="btn btn-primary btn-sm">VEC</a></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    @else
                                        <td style="vertical-align: middle;">
                                            <form action="{{ route('estadilloFind') }}" method="GET">
                                                @csrf
                                                <input type="hidden" readonly name="search_term" value="{{ $serie['id_registre_entrada'] }}">
                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" type="submit">ESTADILLO</button>
                                            </form>
                                        </td>
                                        <td style="vertical-align: middle;"><a href="{{ route('indexVec', array('ref' => $serie['id_registre_entrada'])) }}" class="btn btn-primary btn-sm">VEC</a></td>
                                    @endif
                                @endif
                                @if (Auth::user()->hasAnyRole(['3']))
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}"></td>
                                @endif
                                <td style="vertical-align: middle;"> </td>
                            </tr>
                        @else
                        <tr class="accordian-body collapse" id="collapse{{$key}}">
                            <td colspan="8" style="padding: 0px !important;">
                                <table cellpadding="0" cellspacing="0" class="table mb-0">
                                    <tbody> 
                                        @foreach ($serie as $key2 => $episodi)
                                            @if ($key2 == 0)
                                            <tr class="border-primary table-selected">
                                                <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle; width: 76px;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $episodi["id_registre_entrada"])) }}')">
                                                    <span class="font-weight-bold" style="font-size: 11px;">{{ $episodi["id_registre_entrada"] }}</span>    
                                                </td>
                                                <td style="vertical-align: middle; width: 96px;" class="accordion cursor font-weight-bold" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['min'] }}_{{ $episodi['max'] }} </td>
                                                <td style="vertical-align: middle; width: 168px;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ date('d/m/Y', strtotime($episodi['data'])) }}</td>
                                                <td style="vertical-align: middle; width: 110px;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['setmana'] }}</td>
                                                <td style="vertical-align: middle; width: 159px;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['titol'] }}</td>
                                                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                                                    @if (Auth::user()->hasAnyRole(['2']))
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;">
                                                            <form action="{{ route('estadilloFind') }}" method="GET">
                                                                @csrf
                                                                <input type="hidden" readonly name="search_term" value="{{ $episodi['id_registre_entrada'] }}">
                                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" type="submit">ESTADILLO</button>
                                                            </form>
                                                        </td>
                                                        <td style="vertical-align: middle;"><a href="{{ route('indexVec', array('ref' => $episodi['id_registre_entrada'])) }}" class="btn btn-primary btn-sm">VEC</a></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    @else
                                                        <td style="vertical-align: middle; width: 154px;">
                                                            <form action="{{ route('estadilloFind') }}" method="GET">
                                                                @csrf
                                                                <input type="hidden" readonly name="search_term" value="{{ $episodi['id_registre_entrada'] }}">
                                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" type="submit">ESTADILLO</button>
                                                            </form>
                                                        </td>
                                                        <td style="vertical-align: middle; width: 154px;"><a href="{{ route('indexVec', array('ref' => $episodi['id_registre_entrada'])) }}" class="btn btn-primary btn-sm">VEC</a></td>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->hasAnyRole(['3']))
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                    <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                                @endif
                                                <td style="vertical-align: middle;"> </td>
                                            </tr>
                                            @else
                                            <tr class="table-selected {{ ($episodi->estat == 'Pendent') ? 'border-warning' : (($episodi->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }} accordian-body collapse" id="collapse{{$key}}_{{$key1}}">
                                                <td></td>
                                                <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $episodi->id)) }}')">
                                                    <span class="font-weight-bold" style="font-size: 11px;">{{ $episodi->subreferencia }}</span>
                                                </td>
                                                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($episodi->data_entrega)) }}</td>
                                                <td style="vertical-align: middle;">{{$episodi->setmana}}</td>
                                                <td style="vertical-align: middle;">{{$episodi->titol}}</td>
                                                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                                                    @if (Auth::user()->hasAnyRole(['2']))
                                                        <td style="vertical-align: middle;">{{ $episodi->titol_traduit }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->traductor ? $episodi->traductor->nom_empleat : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->data_traductor != 0 ? date('d/m/Y', strtotime($episodi->data_traductor)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->ajustador ? $episodi->ajustador->nom_empleat : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->data_ajustador != 0 ? date('d/m/Y', strtotime($episodi->data_ajustador)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->linguista ? $episodi->linguista->nom_empleat : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->data_linguista != 0 ? date('d/m/Y', strtotime($episodi->data_linguista)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->director ? $episodi->director->nom_empleat : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->casting == 0 ? '' : 'FET' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->propostes == 0 ? '' : 'FET' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->inserts }}</td>
                                                        <td style="vertical-align: middle;">
                                                            @if (empty($episodi->getEstadillo))
                                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $episodi->id }}, '{{ $episodi->id_registre_entrada.' '.$episodi->titol.' '.$episodi->subreferencia }}')" data-toggle="modal" data-target="#importModal">IMPORTAR</button>
                                                            @else
                                                                <a href="{{  route('estadilloShow', array('id' => $episodi->getEstadillo->id_estadillo )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                                            @endif
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($episodi->vec != 1 || empty($episodi->getVec))
                                                                <a href="{{ route('vecGenerar', array('id' => $episodi->id)) }}" class="btn btn-primary btn-sm">GENERAR</a>
                                                            @else
                                                                <a href="{{ route('mostrarVec', array('id' => $episodi->getVec->id_costos)) }}" class="btn btn-primary btn-sm">VEURE</a>
                                                            @endif
                                                        </td>
                                                        <td style="vertical-align: middle;">{{ $episodi->convos == 0 ? '' : 'FET' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->inici_sala != 0 ? date('d/m/Y', strtotime($episodi->inici_sala)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->final_sala != 0 ? date('d/m/Y', strtotime($episodi->final_sala)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->data_tecnic_mix != 0 ? date('d/m/Y', strtotime($episodi->data_tecnic_mix)) : '' }}</td>
                                                        <td style="vertical-align: middle;">{{ $episodi->retakes }}</td>
                                                    @else
                                                        <td style="vertical-align: middle;">
                                                            @if (empty($episodi->getEstadillo))
                                                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $episodi->id }}, '{{ $episodi->id_registre_entrada.' '.$episodi->titol.' '.$episodi->subreferencia }}')" data-toggle="modal" data-target="#importModal">IMPORTAR</button>
                                                            @else
                                                                <a href="{{ route('estadilloShow', array('id' => $episodi->getEstadillo->id_estadillo )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                                            @endif
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($episodi->vec != 1  || empty($episodi->getVec))
                                                                <a href="{{ route('vecGenerar', array('id' => $episodi->id)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">GENERAR</a>
                                                            @else
                                                                <a href="{{ route('mostrarVec', array('id' => $episodi->getVec->id_costos)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                                            @endif
                                                        </td>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->hasAnyRole(['3']))
                                                    <td style="vertical-align: middle;">{{ $episodi->qc_vo == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->qc_me == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->ppp == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->pps == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->tecnic ? $episodi->tecnic->nom_empleat : '' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->data_tecnic_mix != 0 ? date('d/m/Y', strtotime($episodi->data_tecnic_mix)) : '' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->qc_mix == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->ppe == 0 ? '' : 'FET' }}</td>
                                                    <td style="vertical-align: middle;">{{ $episodi->retakes }}</td>
                                                @endif
                                                <td style="vertical-align: middle;">
                                                    <a href="{{ route('updateRegistreProduccio', array('id' => $episodi->id )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">MODIFICAR</a>
                                                    @if (Auth::user()->hasAnyRole(['4']))
                                                        <button class="btn btn-danger btn-sm" style="font-size: 11px;" onclick="self.seleccionarRegistreProduccio({{ $episodi->id }}, '{{ $episodi->id_registre_entrada.' '.$episodi->titol.' '.$episodi->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                                                        <form id="delete-{{ $episodi->id }}" action="{{ route('deleteRegistre') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" readonly name="id" value="{{ $episodi->id }}">
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>    
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                @endif      
            @endforeach
        </tbody>
    </table>
    <!-- MODAL IMPORTAR ESTADILLOS -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">IMPORTAR ESTADILLO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="message"></span>
                    <form action="{{ route('estadilloImport') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="hidden" readonly class="form-control" id="id_estadillo" name="id_estadillo" value=''>
                                <input type="file" class="custom-file-input" name="import_file" id="inputGroupFile" aria-describedby="inputGroupFileAddon">
                                <label class="custom-file-label" for="inputGroupFile">Importar Estadillo</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon">IMPORTAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarEstadillo(0)">TANCAR</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL ESBORRAR REGISTRE PRODUCCIO -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR REGISTRE PRODUCCIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">Estàs segur/a?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreProduccio(0)">TANCAR</button>
                    <button type="button" class="btn btn-danger" onclick="self.deleteRegistre()">ESBORRAR</button>
                </div>
            </div>
        </div>
    </div>
    
    @if (isset($return))
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary mb-3">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
</div>

<script>
    var self = this;
    self.registrePerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreProduccio = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un registre d'entrada i mostra un missatge en el modal d'esborrar.
    self.seleccionarRegistreProduccio = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el registre de producció <b>' + registreProduccioAlias + '</b>?';
        }
    }
    
    self.seleccionarEstadillo = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            $('#id_estadillo').attr('value', registreProduccioId);
            document.getElementById('message').innerHTML = 'Importar estadillo de <b>' + registreProduccioAlias + '</b>:';
        }
    }
    // Esborra el registre d'entrada seleccionat.
    self.deleteRegistre = function () {
        if (self.registrePerEsborrar != 0) {
            document.all["delete-" + self.registrePerEsborrar].submit(); 
        }
    }

//--------Funcions per el filtra-----------
    function selectSearch() {
    //var value = $('#searchBy').val();

    //alert($('#searchBy').children(":selected").attr("id")); //Com obtenir el id del option
    if ($('#searchBy').children(":selected").attr("id") == 'estat') {
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="Pendent">PENDENT</option><option value="Finalitzada">FINALITZAT</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'date'){
        $('#search_term').remove();
        $('<input type="date" class="form-control" id="search_term" name="search_term">').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'fet'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="0">NO FET</option><option value="1">FET</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'inserts'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="No cal fer">NO CAL FER</option><option value="Cal fer">CAL FER</option><option value="Fet">FET</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'retakes'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="No">NO</option><option value="Si">SI</option><option value="Fet">FET</option></select>').insertAfter('#orderBy');
    }
    else {
        //Canviem el input actual per el que necessitem
        $('#search_term').remove();
        $('<input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar per...">').insertAfter('#orderBy');
    }
    }

    $('#searchBy').change(selectSearch);
</script>


</script>


@stop
