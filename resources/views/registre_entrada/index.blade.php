@extends('layouts.app')

@section('content')

<div class="container">
<div class="row">
        <div class="col">
            <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                Afegir registre d'entrada
            </a>
        </div>
        <!-- FILTRA REGISTRE ENTRADA -->
        <div class="row">
            <div class="col">
                <form method = "GET" action= '{{ route('registreEntradaFind') }}' id='search'>
                    @csrf
                <div class="input-group">
                    <select class="custom-select" id='searchBy' name="searchBy" form="search">
                        <option selected>Buscar per...</option>
                        <option>Referencia</option>
                        <option value="1">Client</option>
                        <option value="2">Estat</option>
                    </select>
                    <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">
                    
                    <select class="custom-select" id='search_Client' name="search_Client" form="search" style="display: none;">
                        @foreach( $clients as $key => $client )
                          <option value="{{$client['id_client']}}">{{$client['nom_client']}}</option>
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
    </div>
    
    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div style="margin-top: 10px;">
        <div class="llegenda">
            <span style="color: lawngreen; font-size: 30px;">&#9646;</span>
            <span>Finalitzat</span>
        </div>
        <div class="llegenda">
            <span style="color: darkorange; font-size: 30px;">&#9646;</span>
            <span>Pendent</span>
        </div>
        <div class="llegenda">
            <span style="color: red; font-size: 30px;">&#9646;</span>
            <span>Cancel·lat</span>
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
                <th>Accions</th>
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
                <td style="vertical-align: middle;">{{ date('d/m/Y H:i:s', strtotime($registreEntrada->entrada)) }}</td>
                <td style="vertical-align: middle;">{{ date('d/m/Y H:i:s', strtotime($registreEntrada->sortida)) }}</td>
                <td style="vertical-align: middle;">{{ $registreEntrada->client->nom_client }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('registreEntradaUpdateView', array('id' => $registreEntrada['id_registre_entrada'])) }}" class="btn btn-primary">Modificar</a>
                    <button class="btn btn-danger" onclick="self.seleccionarRegistreEntrada({{ $registreEntrada['id_registre_entrada'] }}, '{{ $registreEntrada['titol'] }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                    <form id="delete-{{ $registreEntrada['id_registre_entrada'] }}" action="{{ route('esborrarRegistreEntrada') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $registreEntrada['id_registre_entrada'] }}">
                    </form>
                </td>
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
            $('#search_Client').show();
            $('#search_Estat').hide();
        } else if ($('#searchBy').val() == '2'){
            $('#search_term').hide();
            $('#search_Client').hide();
            $('#search_Estat').show();
        } 
        else {
            $('#search_term').show();
            $('#search_Client').hide();
            $('#search_Estat').hide();
        }
    }
    
    $('#searchBy').change(selectSearch); 
</script>


@stop