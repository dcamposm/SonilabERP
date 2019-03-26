@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-between">
        
        <div>
        @if (Auth::user()->hasAnyRole(['1', '4']))
            <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                Afegir registre d'entrada
            </a>
        @endif
            <a href="{{ url('/clients') }}" class="btn btn-success">
                <span class="fas fa-address-book"></span>
                Gestionar Clients
            </a>
        </div>
        <!-- FILTRA REGISTRE ENTRADA -->
        <div>
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
            <div class="input-group row">
                <select class="custom-select" id='searchBy' name="searchBy" form="search">
                    <option selected>Buscar per...</option>
                    <option>Referencia</option>
                    <option>Titol</option>
                    <option value="1">Client</option>
                    <option value="2">Estat</option>
                    <option value="3">Entrada</option>
                    <option value="4">Sortida</option>
                    <option value="5">Servei</option>
                    <option value="6">Idioma</option>
                    <option value="7">Tipus</option>
                    <option value="8">Minuts</option>
                </select>
                <select class="custom-select" id='orderBy' name="orderBy" form="search">
                    <option value="id_registre_entrada" selected>Ordenar per...</option>
                    <option value="id_registre_entrada">Referencia</option>
                    <option value="titol">Titol</option>
                    <option value="id_client">Client</option>
                    <option value="estat">Estat</option>
                    <option value="entrada">Entrada</option>
                    <option value="sortida">Sortida</option>
                    <option value="id_servei">Servei</option>
                    <option value="id_idioma">Idioma</option>
                    <option value="id_media">Tipus</option>
                    <option value="minuts">Minuts</option>
                </select>
                <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">
                <input type="date" class="form-control" id="searchDate" name="searchDate" style="display: none;">
                <input type="number" class="form-control" id="searchMin" name="searchDate" style="display: none;">
                <select class="custom-select" id='search_Client' name="search_Client" form="search" style="display: none;">
                    @foreach( $clients as $key => $client )
                        <option value="{{$client['id_client']}}">{{$client['nom_client']}}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Servei' name="search_Servei" form="search" style="display: none;">
                    @foreach( $serveis as $key => $servei )
                        <option value="{{$servei['id_servei']}}">{{$servei['nom_servei']}}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Idioma' name="search_Idioma" form="search" style="display: none;">
                    @foreach( $idiomes as $key => $idioma )
                        <option value="{{$idioma['id_idioma']}}">{{$idioma['idioma']}}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Media' name="search_Media" form="search" style="display: none;">
                    @foreach( $medies as $key => $media )
                        <option value="{{$media['id_media']}}">{{$media['nom_media']}}</option>
                    @endforeach
                </select>
                <select class="custom-select" id='search_Estat' name="search_Estat" form="search" style="display: none;">
                      <option value="Pendent">Pendent</option>
                      <option value="Finalitzada">Finalitzada</option>
                      <option value="Cancel·lada">Cancel·lada</option>
                </select>

                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                </span>
            </div>
            </form>
        </div>
    </div>
    
    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div style="margin-top: 10px;">
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Finalitzada">
                <span style="color: lawngreen; font-size: 30px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black;">Finalitzat</button>
            </form>
        </div>
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Pendent">
                <span style="color: darkorange; font-size: 30px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black;">Pendent</button>
            </form>
        </div>
        <div class="llegenda">
            <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                @csrf
                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="2">
                <input type="hidden" id="search_Estat" class="form-control" name="search_Estat" value="Cancel·lada">
                <span style="color: red; font-size: 30px;">&#9646;</span><button type="submit" class="btn btn-link" style="text-decoration: none; color: black;">Cancel·lat</button>
            </form>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>REF</th> 
                <th>Títol</th>
                <th>Entrada</th>
                <th>Sortida</th>
                <th>Client</th>
                <th>Servei</th>
                <th>Idioma</th>
                <th>Tipus</th>
                <th>Minuts</th>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                <th>Accions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach( $registreEntrades as $key => $registreEntrada )
            <tr class="table-selected {{ ($registreEntrada->estat == 'Pendent') ? 'border-warning' : (($registreEntrada->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarRegistreEntrada('{{ route('mostrarRegistreEntrada', array('id' => $registreEntrada->id_registre_entrada)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $registreEntrada->id_registre_entrada }}</span>
                </td>
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarRegistreEntrada('{{ route('mostrarRegistreEntrada', array('id' => $registreEntrada->id_registre_entrada)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $registreEntrada->titol }}</span>
                </td>
                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreEntrada->entrada)) }}</td>
                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreEntrada->sortida)) }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->client->nom_client }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->servei->nom_servei }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->idioma->idioma }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->media->nom_media }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->minuts }}</td>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                <td style="vertical-align: middle;">
                    <a href="{{ route('registreEntradaUpdateView', array('id' => $registreEntrada['id_registre_entrada'])) }}" class="btn btn-primary">Modificar</a>
                    <button class="btn btn-danger" onclick="self.seleccionarRegistreEntrada({{ $registreEntrada['id_registre_entrada'] }}, '{{ $registreEntrada['titol'] }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                    <form id="delete-{{ $registreEntrada['id_registre_entrada'] }}" action="{{ route('esborrarRegistreEntrada') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $registreEntrada['id_registre_entrada'] }}">
                    </form>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar registre d'entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreEntrada(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarRegistreEntrada()">Esborrar</button>
                </div>
            </div>
        </div>
    </div>

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
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '2'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').show();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '3' || $('#searchBy').val() == '4'){
            $('#search_term').hide();
            $('#searchDate').show();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
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
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '7'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').show();
            $('#searchMin').hide();
        } else if ($('#searchBy').val() == '8'){
            $('#search_term').hide();
            $('#searchDate').hide();
            $('#search_Client').hide();
            $('#search_Estat').hide();
            $('#search_Servei').hide();
            $('#search_Idioma').hide();
            $('#search_Media').hide();
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
            $('#searchMin').hide();
        }
    }
    
    $('#searchBy').change(selectSearch); 
</script>


@stop
