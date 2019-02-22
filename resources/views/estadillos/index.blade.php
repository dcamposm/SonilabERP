@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-3">
            <a href="{{ url('/estadillos/crear') }}" class="btn btn-success">
                <span class="fas fa-clipboard-list"></span>
                Crear estadillo
            </a>
        </div>
        <div class="col">
            <form  action="{{ route('estadilloImport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="import_file" style="font-weight: bold">Importar Estadillo:</label>
                <input type="file" name="import_file">
                <button type="submit" class="btn btn-success col-2">Importar</button>
            </form>
        </div>
    </div>

    {{-- TABLA DE ESTADILLOS --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Titol</th> 
                <th>Validat</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $estadillos as $key => $estadillo )
            <tr class="table-selected">
                <td class="cursor"  style="vertical-align: middle;" onclick="self.mostrarEstadillo('{{ route('estadilloShow', array('id' => $estadillo->id_estadillo)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $estadillo->registreEntrades->titol }} {{ $estadillo->id_registre_produccio }}</span>
                </td>
                <td style="vertical-align: middle;">{{ $estadillo->validat == 0 ? 'No' : 'Si' }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('estadilloUpdateView', array('id' => $estadillo['id_estadillo'])) }}" class="btn btn-primary">Modificar</a>
                    <button class="btn btn-danger" onclick="self.seleccionarEstadillo({{ $estadillo['id_estadillo'] }}, '{{ $estadillo->registreEntrades->titol }} {{ $estadillo->id_registre_produccio }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                    <form id="delete-{{ $estadillo['id_estadillo'] }}" action="{{ route('esborrarEstadillo') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $estadillo['id_estadillo'] }}">
                    </form>
                </td>
            </tr>
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
</script>


@stop