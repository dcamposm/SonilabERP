@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-between">

        <a href="{{ url('/estadillos/crear') }}" class="btn btn-success">
            <span class="fas fa-clipboard-list"></span>
            Crear estadillo
        </a>

        <div class="col-5">
            <form action="{{ route('estadilloImport') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="import_file" id="inputGroupFile" aria-describedby="inputGroupFileAddon">
                      <label class="custom-file-label" for="inputGroupFile">Importar Estadillo</label>
                    </div>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon">Importar</button>
                    </div>
                </div>
            </form>
        </div>   
        <div>
            <form method = "GET" action= '{{ route('estadilloFind') }}' id='search'>
                @csrf
            <div class="input-group">
                <select class="custom-select" id='searchBy' name="searchBy" form="search">
                    <option selected>Buscar per...</option>
                    <option>Referencia</option>
                    <option value="1">Validat </option>
                </select>
                <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar Estadillo...">
                <select class="custom-select" id='search_Validat' name="search_Validat" form="search" style="display: none;">
                      <option value="1">Si</option>
                      <option value="0">No</option>
                </select>

                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                </span>
            </div>
            </form>
        </div>
    </div>
    <br>
    {{-- TABLA DE ESTADILLOS --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Estadillo</th> 
                <th>Validat</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $showEstadillos as $key => $estadillos )
                @foreach( $estadillos as $key2 => $estadillo )
                    <tr class="table-selected">
                        <td class="cursor"  style="vertical-align: middle;" onclick="self.mostrarEstadillo('{{ isset($estadillo['id_estadillo']) ? route('estadilloShow', array('id' => $estadillo['id_estadillo'])) : route('estadilloShow', array('id' => $key, 'id_setmana' => $estadillo['setmana'])) }}')">
                            <span class="font-weight-bold" style="font-size: 1rem;">{{ $key }} {{ $estadillo['titol'] }} {{ !isset($estadillo['min']) ? '' : ( $estadillo['min'] != $estadillo['max'] ? $estadillo['min'].'-'.$estadillo['max'] : $estadillo['min']) }}</span>
                        </td>
                        <td style="vertical-align: middle;">{{ $estadillo['validat'] == 0 ? 'No' : 'Si' }}</td>
                        @if (isset($estadillo['id_estadillo']))
                            <td style="vertical-align: middle;">
                                <a href="{{ route('estadilloUpdateView', array('id' => $estadillo['id_estadillo'])) }}" class="btn btn-primary">Modificar</a>
                                <button class="btn btn-danger" onclick="self.seleccionarEstadillo({{ $key }}, '{{ $estadillo['titol'] }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                                <form id="delete-{{ $estadillo['id_estadillo'] }}" action="{{ route('esborrarEstadillo') }}" method="POST">
                                    @csrf
                                    <input type="hidden" readonly name="id" value="{{ $estadillo['id_estadillo'] }}">
                                </form>
                            </td>
                        @else
                            <td style="vertical-align: middle;">
                                 <a href="{{ route('estadilloShowSetmana', array($key, 'id_setmana' => $estadillo['setmana'])) }}" class="btn btn-primary">Veure estadillos</a>
                                 <a href="{{ route('estadilloShow', array($key, 'id_setmana' => $estadillo['setmana'])) }}" class="btn btn-primary">Veure actors</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- MODAL ESBORRAR ESTADILLO -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar estadillo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarEstadillo(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarEstadillo()">Esborrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var self = this;
    self.estadilloPerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un estadillo.
    self.mostrarEstadillo = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un estadillo i mostra un missatge en el modal d'esborrar.
    self.seleccionarEstadillo = function (estadilloId, estadilloAlias) {
        self.estadilloPerEsborrar = estadilloId;
        if (estadilloAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el estadillo <b>' + estadilloAlias + '</b>?';
        }
    }

    // Esborra el d'un estadillo seleccionat.
    self.esborrarEstadillo = function () {
        if (self.estadilloPerEsborrar != 0) {
            document.all["delete-" + self.estadilloPerEsborrar].submit(); 
        }
    }
     function selectSearch() {
        //var value = $('#searchBy').val();
        
        //alert(value);
        if ($('#searchBy').val() == '1') {
            $('#search_term').hide();
            $('#search_Validat').show();
        } else {
            $('#search_term').show();
            $('#search_Validat').hide();
        }
    }
    
    $('#searchBy').change(selectSearch);   
</script>
   

@stop
