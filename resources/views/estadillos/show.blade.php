@extends('layouts.app')

@section('content')

<div class="container">
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
            @foreach( $registreProduccio as $registre )
                    @if (isset($registre->getEstadillo))
                        <tr class="table-selected">
                            <td class="cursor"  style="vertical-align: middle;" onclick="self.mostrarEstadillo('{{ route('estadilloShow', array('id' => $registre->getEstadillo->id_estadillo)) }}')">
                                <span class="font-weight-bold" style="font-size: 1rem;">{{ $registre->id_registre_entrada }} {{ $registre->nom }} {{ $registre->id_sub }}</span>
                            </td>
                            <td style="vertical-align: middle;">{{ $registre->estadillo == 0 ? 'No' : 'Si' }}</td>
                            <td style="vertical-align: middle;">
                                <a href="{{ route('estadilloUpdateView', array('id' => $registre->getEstadillo->id_estadillo)) }}" class="btn btn-primary">Modificar</a>
                                <button class="btn btn-danger" onclick="self.seleccionarEstadillo({{ $registre->getEstadillo->id_estadillo }}, '{{ $registre->id_registre_entrada }} {{ $registre->nom }} {{ $registre->id_sub }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                                <form id="delete-{{ $registre->getEstadillo->id_estadillo }}" action="{{ route('esborrarEstadillo') }}" method="POST">
                                    @csrf
                                    <input type="hidden" readonly name="id" value="{{ $registre->getEstadillo->id_estadillo }}">
                                </form>
                            </td>
                        </tr>
                    @endif
            @endforeach
        </tbody>
    </table>
    <br>
    <div>
        <a href="/estadillos" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            Tornar enrere
        </a>
    </div>
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