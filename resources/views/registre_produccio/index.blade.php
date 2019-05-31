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
            <button class="btn btn-success mt-1" data-toggle="modal" data-target="#ModalInsert">
                <span class="fas fa-atlas"></span>
                AFEGIR REGISTRE DE PRODUCCIÓ
            </button>
            @if (Auth::user()->hasAnyRole(['4']))
            <a href="{{ url('/estadillos') }}" class="btn btn-success mt-1">
                <span class="fas fa-clipboard-list"></span>
                ESTADILLOS
            </a>
            @endif
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <a href="{{ url('/vec') }}" class="btn btn-success mt-1">
                <i class="fas fa-calculator"></i>
                VEC
            </a>
            @endif
        </div>
        @endif
        <!-- FILTRA REGISTRE PRODUCCIO -->
        <div class="row mt-1">
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
                                <option value="responsable" id="responsable">RESPONSABLE</option>
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
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table tableIndex" id="parentTable" style="margin-top: 10px;  min-width: 1000px; border-collapse:collapse;">
        <thead>
            <tr>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                    <th>REF.</th> 
                    <th>SUB-REF</th> 
                    <th>DATA D'ENTREGA</th>
                    <th>SETMANA</th>
                    <th>RESPONSABLE</th>
                    <th>TÍTOL ORIGINAL</th>
                    <th>ESTADILLO</th>
                    <th>VEC</th>
                    <th>ACCIONS</th>
                @elseif (Auth::user()->hasAnyRole(['2']))
                    <th>REF.</th> 
                    <th>SUB-REF</th> 
                    <th>DATA D'ENTREGA</th>
                    <th>SETMANA</th>
                    <th>RESPONSABLE</th>
                    <th>TÍTOL ORIGINAL</th>
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
                    <th>ACCIONS</th>
                @elseif (Auth::user()->hasAnyRole(['3']))
                    <th>REF.</th> 
                    <th>SUB-REF</th> 
                    <th>DATA D'ENTREGA</th>
                    <th>SETMANA</th>
                    <th>RESPONSABLE</th>
                    <th>TÍTOL ORIGINAL</th>
                    <th>QC VO</th>
                    <th>QC M&E</th>
                    <th>PPP</th>
                    <th>PPS</th>
                    <th>TÈCNIC MIX</th>
                    <th>DATA MIX</th>
                    <th>QC MIX</th>
                    <th>PPE</th>
                    <th>RETAKES</th>
                    <th>ACCIONS</th>
                @endif
            </tr>
        </thead>
        <tbody class="panel">
            @foreach( $registreProduccions as $key => $registreProduccio )
                @if (isset($registreProduccio->id))
                    <tr class="table-selected {{ ($registreProduccio->estat == 'Pendent') ? 'border-warning' : (($registreProduccio->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                        <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $registreProduccio->id_registre_entrada)) }}')">
                            @foreach ($missatges->where('id_referencia', $registreProduccio->id) as $missatge)
                                @if ($missatge->missatge == 'NEW')
                                    <span class="texto-vertical text-success font-weight-bold float-left" style="margin-left: -27px;">NEW</span>
                                    @break
                                @endif
                            @endforeach
                            <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->id_registre_entrada }}</span>    
                        </td>
                        <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}')">
                            <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->subreferencia }}</span>
                        </td>
                        <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega)) }}</td>
                        <td style="vertical-align: middle;">{{$registreProduccio->setmana}}</td>
                        <td style="vertical-align: middle;">{{!empty($registreProduccio->registreEntrada->usuari->nom_cognom) ? $registreProduccio->registreEntrada->usuari->nom_cognom : ''}}</td>
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
                                        <a href="{{ route('mostrarVec', array('id' => $registreProduccio->id_registre_entrada)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
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
                                        <a href="{{ route('mostrarVec', array('id' => $registreProduccio->id_registre_entrada)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
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
                            <a href="{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">MODIFICAR</a>
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
                    <!-- ----------------REGISTRES DE SERIES I DOCUMENTALS------------------------- -->
                    @foreach( $registreProduccio as $key1 => $serie )
                        @foreach ($serie as $key2 => $episodi)
                            @if ($key2 == 0)
                            <tr class="{{ ($episodi['estat'] == 'Pendent') ? 'border-warning' : (($episodi['estat'] == 'Finalitzada') ? 'border-success' : 'border-danger') }}" id="collapse{{$key}}">
                                <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $episodi["id_registre_entrada"])) }}')">
                                    @if ($episodi['new'] == 1)
                                        <span class="texto-vertical text-success font-weight-bold float-left" style="margin-left: -27px;">NEW</span>
                                    @endif
                                    <span class="font-weight-bold" style="font-size: 11px;">{{ $episodi["id_registre_entrada"] }}</span>    
                                </td>
                                <td style="vertical-align: middle;" class="accordion cursor font-weight-bold" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['min'] }}_{{ $episodi['max'] }} </td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ date('d/m/Y', strtotime($episodi['data'])) }}</td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['setmana'] }}</td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{$episodi['responsable']}}</td>
                                <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}">{{ $episodi['titol'] }}</td>
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
                                        @if ($episodi['estadillo'] == 0)
                                            <td></td>
                                        @else
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('estadilloShow', array('id' => $episodi["id_registre_entrada"], 'id_setmana' => $episodi['setmana'])) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                            </td>
                                        @endif
                                        @if ($episodi['vec'] != 0)
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('mostrarVec', array('id' => $episodi['id_registre_entrada'], 'data' => date('d-m-Y', strtotime($episodi['data'])))) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                            </td>
                                        @else
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('vecGenerarSetmana', array('id' => $episodi['id_registre_entrada'], 'setmana' => $episodi['setmana'])) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">GENERAR</a>
                                            </td>
                                        @endif
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                        <td style="vertical-align: middle;" class="accordion cursor" data-toggle="collapse" data-target="#collapse{{$key}}_{{$key1}}"></td>
                                    @else
                                        @if ($episodi['estadillo'] == 0)
                                            <td></td>
                                        @else
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('estadilloShow', array('id' => $episodi["id_registre_entrada"], 'id_setmana' => $episodi['setmana'])) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                            </td>
                                        @endif
                                        @if ($episodi['vec'] != 0)
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('mostrarVec', array('id' => $episodi['id_registre_entrada'], 'data' => date('d-m-Y', strtotime($episodi['data'])))) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
                                            </td>
                                        @else
                                            <td style="vertical-align: middle;">
                                                <a href="{{ route('vecGenerarSetmana', array('id' => $episodi['id_registre_entrada'], 'setmana' => $episodi['setmana'])) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">GENERAR</a>
                                            </td>
                                        @endif
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
                                <td style="vertical-align: middle;">
                                    @foreach ($missatges->where('id_referencia', $episodi->id) as $missatge)
                                        @if ($missatge->missatge == 'NEW')
                                            <span class="texto-vertical text-success font-weight-bold float-left" style="margin-left: -27px;">NEW</span>
                                            @break
                                        @endif
                                    @endforeach
                                    {{$episodi->id_registre_entrada}}
                                </td>
                                <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $episodi->id)) }}')">
                                    <span class="font-weight-bold" style="font-size: 11px;">{{ $episodi->subreferencia }}</span>
                                </td>
                                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($episodi->data_entrega)) }}</td>
                                <td style="vertical-align: middle;">{{$episodi->setmana}}</td>
                                <td style="vertical-align: middle;">{{$episodi->registreEntrada->usuari->nom_cognom}}</td>
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
                                                <a href="{{ route('estadilloShow', array('id' => $episodi->getEstadillo->id_estadillo )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">VEURE</a>
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
                                        <td style="vertical-align: middle;"></td>
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
                                    <a href="{{ route('mostrarRegistreProduccio', array('id' => $episodi->id)) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">MODIFICAR</a>
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
    
    <!-- MODAL CREAR REGISTRE PRODUCCIO -->
    <div class="modal fade" id="ModalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">CREAR REGISTRE DE PRODUCCIÓ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('createRegistreBasic')}}" enctype="multipart/form-data"">
                    @csrf
                    <fieldset class="border p-2">
                        <legend class="w-auto">DADES BÀSIQUES:</legend>
                        <div class="row">
                            <div class="form-group col-12 col-sm-6">
                                <label for="id_registre_entrada">REFERÈNCIA</label>
                                <select name="id_registre_entrada" id="id_registre_entrada" class="form-control">
                                    @foreach ($registreEntrades as $key => $entrada) 
                                      <option value="{{ $entrada->id_registre_entrada }}">{{ $entrada->id_registre_entrada }} {{ $entrada->titol }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="subreferencia">SUB-REFERÈNCIA</label>
                                <input type="text" name="subreferencia" id="subreferencia" class="form-control">
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="data_entrega">DATA D'ENTREGA</label>
                                <input type="date" name="data_entrega" id="data_entrega" class="form-control">
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="setmana">SETMANA</label>
                                <input type="number" name="setmana" id="setmana" class="form-control" min="0">
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="titol">TÍTOL ORIGINAL</label>
                                <input type="text" name="titol" id="titol" class="form-control">
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="estat">ESTAT</label>
                                <select name="estat" id="estat" class="form-control">
                                  <option value="Pendent">Pendent</option>
                                  <option value="Finalitzada">Finalitzada</option>
                                  <option value="Cancel·lada">Cancel·lada</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('estat') }}</span>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer justify-content-between mt-3">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">TANCAR</button>
                    <button type="submit" class="btn btn-success col-4">CREAR</button>
                </div>
                </form>
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
    
    @if (Route::currentRouteName() == "registreProduccioFind")
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary mb-3">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
</div>

<script>
    var usuaris = @json($usuaris);
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/registreProduccioIndex.js') }}"></script>

@stop
