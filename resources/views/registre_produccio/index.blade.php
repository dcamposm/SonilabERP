@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        @if(Auth::user()->hasAnyRole(['1','2','4']))
        <div class="col">
            <a href="{{ url('/registreProduccio/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                AFEGIR REGISTRE DE PRODUCCIÓ
            </a>
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <a href="{{ url('/estadillos') }}" class="btn btn-success">
                <span class="fas fa-clipboard-list"></span>
                ESTADILLOS
            </a>
            @endif
        </div>
        @endif
        <!-- FILTRA REGISTRE PRODUCCIO -->
        <div class="row">
            <div class="col">
                <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                    @csrf
                    <div class="input-group">
                        <select class="custom-select" id='searchBy' name="searchBy" form="search">
                            <option selected>BUSCAR PER...</option>
                            <option value='1'>REFERENCIA</option>
                            <option value="2">PRODUCCIÓ</option>
                            <option value="3">ESTAT</option>
                        </select>
                        <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">

                        <select class="custom-select" id='search_Estat' name="search_Estat" form="search" style="display: none;">
                            <option value="Pendent">PENDENT</option>
                            <option value="Cancel·lada">CANCEL·LADA</option>
                        </select>

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
    <table class="table" style="margin-top: 10px;  min-width: 1200px; font-size: 10px;">
        <thead>
            <tr>
                <th>REF.</th> 
                <th>SUB-REF</th> 
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <th>DATA D'ENTRADA</th>
                    <th>SETMANA</th>
                    <th>TÍTOL ORIGINAL</th>
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
                        <th>CONVOS</th>
                        <th>INICI SALA</th>
                        <th>FINAL SALA</th>
                        <th>DATA MIX</th>
                        <th>RETAKES</th>
                    @else
                        <th>ESTADILLO</th>
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
        <tbody>
            @foreach( $registreProduccions as $key => $registreProduccio )
            <tr class="table-selected {{ ($registreProduccio->estat == 'Pendent') ? 'border-warning' : (($registreProduccio->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $registreProduccio->id_registre_entrada)) }}')">
                    <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->id_registre_entrada }}</span>    
                </td>
                <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}')">
                    <span class="font-weight-bold" style="font-size: 11px;">{{ $registreProduccio->subreferencia }}</span>
                </td>
                @if (Auth::user()->hasAnyRole(['1', '2', '4']))
                    <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega)) }}</td>
                    <td style="vertical-align: middle;">{{$registreProduccio->setmana}}</td>
                    <td style="vertical-align: middle;">{{$registreProduccio->titol}}</td>
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
                            @if ($registreProduccio->estadillo != 1)
                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESTADILLO</button>
                            @else
                                <a href="{{ $registreProduccio->subreferencia==0 ? route('estadilloShow', array('id' => $registreProduccio->estadillo->id_estadillo )) : route('estadilloShow', array('id' => $registreProduccio->id_registre_entrada, 'id_setmana' => $registreProduccio->setmana )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">ESTADILLO</a>
                            @endif
                        </td>
                        <td style="vertical-align: middle;">{{ $registreProduccio->convos == 0 ? '' : 'FET' }}</td>
                        <td style="vertical-align: middle;">{{ $registreProduccio->inici_sala != 0 ? date('d/m/Y', strtotime($registreProduccio->inici_sala)) : '' }}</td>
                        <td style="vertical-align: middle;">{{ $registreProduccio->final_sala != 0 ? date('d/m/Y', strtotime($registreProduccio->final_sala)) : '' }}</td>
                        <td style="vertical-align: middle;">{{ $registreProduccio->data_tecnic_mix != 0 ? date('d/m/Y', strtotime($registreProduccio->data_tecnic_mix)) : '' }}</td>
                        <td style="vertical-align: middle;">{{ $registreProduccio->retakes }}</td>
                    @else
                        <td style="vertical-align: middle;">
                            @if ($registreProduccio->estadillo != 1)
                                <button class="btn btn-primary btn-sm" style="font-size: 11px;" onclick="self.seleccionarEstadillo({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESTADILLO</button>
                            @else
                                <a href="{{ $registreProduccio->subreferencia==0 ? route('estadilloShow', array('id' => $registreProduccio->getEstadillo->id_estadillo )) : route('estadilloShow', array('id' => $registreProduccio->id_registre_entrada, 'id_setmana' => $registreProduccio->setmana )) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">ESTADILLO</a>
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
            @endforeach
        </tbody>
    </table>
    
    <!-- MODAL IMPORTAR ESTADILLOS -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">IMPORTAR ESTADILLO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="message">...</span>
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
    
    <!-- MODAL ESBORRAR REGISTRE ENTRADA -->
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
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreProduccio(0)">TANCAR</button>
                    <button type="button" class="btn btn-danger" onclick="self.deleteRegistre()">ESBORRAR</button>
                </div>
            </div>
        </div>
    </div>
    
    @if (isset($return))
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR ENRERA
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

    //alert(value);
    if ($('#searchBy').val() == '3') {
        $('#search_term').hide();
        $('#search_Estat').show();
    }
    else {
        $('#search_term').show();
        $('#search_Estat').hide();
    }
    }

    $('#searchBy').change(selectSearch);
</script>


</script>


@stop
