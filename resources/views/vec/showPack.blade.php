@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ url('/vec') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
    </div>

    {{-- TABLA DE COSTOS --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>REFERÈNCIA</th> 
                <th>TITOL</th>
                <th>CLIENT</th>
                <th>EPISODI</th>
                <th>ENTREGA</th>
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $costos as $key => $vec )
                <tr>
                    <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarVec('{{ route('mostrarVec', array('id' => $key)) }}')">
                        <span class="font-weight-bold" style="font-size: 1rem;">{{ $vec['referencia'] }}</span>
                    </td>
                    <td style="vertical-align: middle;">{{ $vec['titol'] }}</td>
                    <td style="vertical-align: middle;">{{ $vec['client'] }}</td>
                    <td style="vertical-align: middle;">{{ $vec['episodi'] }}</td>
                    <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($vec['entrega'])) }}</td>
                    <td style="vertical-align: middle;">
                        <a href="{{ route('vecActualitzar', array('id' => $key)) }}" class="btn btn-warning">ACTUALITZAR</a>
                        <button class="btn btn-danger" onclick="self.seleccionarVec({{ $key }}, '{{ $vec['referencia'].' '.$vec['titol'] }}')" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                        <form id="delete-{{ $key }}" action="{{ route('esborrarVec') }}" method="POST">
                            @csrf
                            <input type="hidden" readonly name="id" value="{{ $key }}">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL ESBORRAR VEC -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar valoració económica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarVec(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarVec()">Esborrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var self = this;
    self.vecPerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un vec.
    self.mostrarVec = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un vec i mostra un missatge en el modal d'esborrar.
    self.seleccionarVec = function (vecId, vecAlias) {
        self.vecPerEsborrar = vecId;
        if (vecAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar la valoracío económica de <b>' + vecAlias + '</b>?';
        }
    }

    // Esborra el vec seleccionat.
    self.esborrarVec = function () {
        if (self.vecPerEsborrar != 0) {
            document.all["delete-" + self.vecPerEsborrar].submit(); 
        }
    }
</script>


@stop
