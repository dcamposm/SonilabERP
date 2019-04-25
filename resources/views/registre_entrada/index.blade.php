@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-between">
        
        <div>
        @if (Auth::user()->hasAnyRole(['1', '4']))
            <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                NOVA REFERÈNCIA
            </a>
        @endif
            <a href="{{ url('/clients') }}" class="btn btn-success">
                <span class="fas fa-address-book"></span>
                CLIENTS
            </a>
        </div>
        <!-- FILTRA REGISTRE ENTRADA -->
        <div>
            <form method = "GET" action= "{{ route('registreEntradaFind') }}" id='search'>
                @csrf
            <div class="input-group row">
                <select class="custom-select" id='searchBy' name="searchBy" form="search">
                    <option selected>BUSCAR PER...</option>
                    <option>REFERENCIA</option>
                    <option>TÍTOL</option>
                    <option value="1">CLIENT</option>
                    <option value="2">ESTAT</option>
                    <option value="3">RESPONSABLE</option>
                    <option value="4">SORITDA</option>
                    <option value="5">SERVEI</option>
                    <option value="6">IDIOMA</option>
                    <option value="7">TIPUS</option>
                    <option value="8">MINUTS</option>
                </select>
                <select class="custom-select" id='orderBy' name="orderBy" form="search">
                    <option value="id_registre_entrada" selected>ORDENAR PER...</option>
                    <option value="id_registre_entrada">REFERENCIA</option>
                    <option value="titol">TÍTOL</option>
                    <option value="id_client">CLIENT</option>
                    <option value="estat">ESTAT</option>
                    <option value="responsable">RESPONSABLE</option>
                    <option value="sortida">SORTIDA</option>
                    <option value="id_servei">SERVEI</option>
                    <option value="id_idioma">IDIOMA</option>
                    <option value="id_media">TIPUS</option>
                    <option value="minuts">MINUTS</option>
                </select>
                <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">
                <input type="date" class="form-control" id="searchDate" name="searchDate" style="display: none;">
                <input type="number" class="form-control" id="searchMin" name="searchDate" style="display: none;">
                <select class="custom-select" id='search_Client' name="search_Client" form="search" style="display: none;">
                    @foreach( $clients as $key => $client )
                        <option value="{{$client['id_client']}}">{{ mb_strtoupper( $client['nom_client'] ) }}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Servei' name="search_Servei" form="search" style="display: none;">
                    @foreach( $serveis as $key => $servei )
                        <option value="{{$servei['id_servei']}}">{{ mb_strtoupper( $servei['nom_servei'] ) }}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Idioma' name="search_Idioma" form="search" style="display: none;">
                    @foreach( $idiomes as $key => $idioma )
                        <option value="{{$idioma['id_idioma']}}">{{ mb_strtoupper( $idioma['idioma'] ) }}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Media' name="search_Media" form="search" style="display: none;">
                    @foreach( $medies as $key => $media )
                        <option value="{{$media['id_media']}}">{{ mb_strtoupper( $media['nom_media'] ) }}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Resp' name="search_Resp" form="search" style="display: none;">
                    @foreach( $usuaris as $usuari )
                        <option value="{{$usuari['id_usuari']}}">{{ mb_strtoupper( $usuari['nom_usuari'] ) }}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Estat' name="search_Estat" form="search" style="display: none;">
                      <option value="Finalitzada">FINALITZADA</option>
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
    
    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div class="d-flex justify-content-end" style="margin-top: 10px;">
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Finalitzada">
                <input type="hidden" id="orderBy" class="form-control" name="orderBy" value="id_registre_entrada">

                <span style="color: lawngreen; font-size: 15px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black; font-size: 11px; padding: 1px;">FINALITZAT</button>
            </form>
        </div>
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Pendent">
                <input type="hidden" id="orderBy" class="form-control" name="orderBy" value="id_registre_entrada">
                <span style="color: darkorange; font-size: 15px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black; font-size: 11px; padding: 1px;">PENDENT</button>
            </form>
        </div>
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Cancel·lada">
                <input type="hidden" id="orderBy" class="form-control" name="orderBy" value="id_registre_entrada">
                <span style="color: red; font-size: 15px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black; font-size: 11px; padding: 1px;">CANCEL·LAT</button>
            </form>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <div class="table-responsive">
    <table class="table" style="margin-top: 10px; min-width: 1200px; font-size: 11px;">
        <thead>
            <tr>
                <th>REF.</th> 
                <th>TÍTOL</th>
                <th>PRIMERA ENTRAGA</th>
                <th>RESPONSABLE</th>
                <th>CLIENT</th>
                <th>SERVEI</th>
                <th>IDIOMA</th>
                <th>TIPUS</th>
                <th>MINUTS TOTALS</th>
                <th>EPISODIS TOTALS</th>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                <th>ACCIONS</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach( $registreEntrades as $key => $registreEntrada )
            <tr class="table-selected {{ ($registreEntrada->estat == 'Pendent') ? 'border-warning' : (($registreEntrada->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarRegistreEntrada('{{ route('mostrarRegistreEntrada', array('id' => $registreEntrada->id_registre_entrada)) }}')">
                    <span class="font-weight-bold">{{ $registreEntrada->id_registre_entrada }}</span>
                </td>
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarRegistreEntrada('{{ route('mostrarRegistreEntrada', array('id' => $registreEntrada->id_registre_entrada)) }}')">
                    <span class="font-weight-bold">{{ $registreEntrada->titol }}</span>
                </td>
                
                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreEntrada->sortida)) }}</td>
                <td style="vertical-align: middle;">{{ isset($registreEntrada->usuari) ? $registreEntrada->usuari->nom_usuari :  ''}}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->client->nom_client }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->servei->nom_servei }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->idioma->idioma }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->media->nom_media }}</td>
                <td style="vertical-align: middle; text-align: center;">{{ $registreEntrada->minuts }}</td>
                <td style="vertical-align: middle; text-align: center;">{{ $registreEntrada->total_episodis }}</td>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                <td style="vertical-align: middle;">
                    <a href="{{ route('registreEntradaUpdateView', array('id' => $registreEntrada['id_registre_entrada'])) }}" class="btn btn-primary btn-sm" style="font-size: 11px;">MODIFICAR</a>
                    @if (Auth::user()->hasAnyRole(['4']))
                        <button class="btn btn-danger btn-sm" onclick="self.seleccionarRegistreEntrada({{ $registreEntrada['id_registre_entrada'] }}, '{{ $registreEntrada['titol'] }}')" data-toggle="modal" data-target="#exampleModalCenter" style="font-size: 11px;">ESBORRAR</button>
                        <form id="delete-{{ $registreEntrada['id_registre_entrada'] }}" action="{{ route('esborrarRegistreEntrada') }}" method="POST">
                            @csrf
                            <input type="hidden" readonly name="id" value="{{ $registreEntrada['id_registre_entrada'] }}">
                        </form>
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>    
    <!-- MODAL ESBORRAR REGISTRE ENTRADA -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR REGISTRE D'ENTRADA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">Estàs segur/a</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreEntrada(0)">TANCAR</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarRegistreEntrada()">ESBORRAR</button>
                </div>
            </div>
        </div>
    </div>
    @if (isset($return))
        <a href="{{ url('/registreEntrada') }}" class="btn btn-primary mb-3 mt-3">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
</div>

<script>
    var self = this;
    self.registrePerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreEntrada = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un registre d'entrada i mostra un missatge en el modal d'esborrar.
    self.seleccionarRegistreEntrada = function (registreEntradaId, registreEntradaAlias) {
        self.registrePerEsborrar = registreEntradaId;
        if (registreEntradaAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el registre d\'entrada <b>' + registreEntradaAlias + '</b>?';
        }
    }

    // Esborra el registre d'entrada seleccionat.
    self.esborrarRegistreEntrada = function () {
        if (self.registrePerEsborrar != 0) {
            document.all["delete-" + self.registrePerEsborrar].submit(); 
        }
    }
    
    //--------Funcions per el filtra-----------
    function selectSearch() {
        //var value = $('#searchBy').val();
        
        //alert(value);
        if ($('#searchBy').val() == '1') {
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').show();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '2'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').show();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '3'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').show();
            $('#searchMin').hide();
        }  else if ($('#searchBy').val() == '4'){
            $('#search_term').hide();
            $('#searchDate').show();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '5'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').show();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '6'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').show();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '7'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').show();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '8'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').show();
        } 
        else {
            $('#search_term').show();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#search_Resp').hide();
            $('#searchMin').hide();
        }
    }
    
    $('#searchBy').change(selectSearch); 
</script>


@stop
