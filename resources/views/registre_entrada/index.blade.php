@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-between">
        <div class="col mt-1">
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
        <div class="mt-1">
            <form method = "GET" action= "{{ route('registreEntradaFind') }}" id='search'>
                @csrf
            <div class="input-group row">
                <select class="custom-select" id='searchBy' name="searchBy" form="search">
                    <option value="id_registre_entrada" selected>BUSCAR PER...</option>
                    <option value="id_registre_entrada">REFERENCIA</option>
                    <option value="titol">TÍTOL</option>
                    <option value="id_client" id="select">CLIENT</option>
                    <option value="estat" id="select">ESTAT</option>
                    <option value="id_usuari" id="select">RESPONSABLE</option>
                    <option value="sortida">SORITDA</option>
                    <option value="id_servei" id="select">SERVEI</option>
                    <option value="id_idioma" id="select">IDIOMA</option>
                    <option value="id_media" id="select">TIPUS</option>
                    <option value="minuts">MINUTS</option>
                </select>
                <select class="custom-select" id='orderBy' name="orderBy" form="search">
                    <option value="id_registre_entrada" selected>ORDENAR PER...</option>
                    <option value="id_registre_entrada">REFERENCIA</option>
                    <option value="titol">TÍTOL</option>
                    <option value="id_client">CLIENT</option>
                    <option value="estat">ESTAT</option>
                    <option value="id_usuari">RESPONSABLE</option>
                    <option value="sortida">SORTIDA</option>
                    <option value="id_servei">SERVEI</option>
                    <option value="id_idioma">IDIOMA</option>
                    <option value="id_media">TIPUS</option>
                    <option value="minuts">MINUTS</option>
                </select>
                <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">
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
    <table class="table tableIndex" style="margin-top: 10px; min-width: 1200px;">
        <thead>
            <tr>
                <th>REF.</th> 
                <th>TÍTOL</th>
                <th>PRIMERA ENTREGA</th>
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
                <td style="vertical-align: middle;">{{ isset($registreEntrada->usuari) ? $registreEntrada->usuari->nom_cognom :  ''}}</td>
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
    @if (Route::currentRouteName() == "registreEntradaFind")
        <a href="{{ url('/registreEntrada') }}" class="btn btn-primary mb-3 mt-3">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
</div>

<script>
    var usuaris = @json($usuaris);
    var clients = @json($clients);
    var serveis = @json($serveis);
    var idiomes = @json($idiomes);
    var medies = @json($medies);
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/registreEntradaIndex.js') }}"></script>

@stop
