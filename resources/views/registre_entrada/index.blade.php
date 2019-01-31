@extends('layouts.app')

@section('content')

<div>
    <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">
        <span class="fas fa-atlas"></span>
        Afegir registre d'entrada
    </a>
</div>

<div class="container">
    
    {{-- TODO: Realizar la vista principal. Usar la variable $registreEntrades para coger los registros de entrada. --}}
    <table class="table">
        <thead>
            <tr>
                <th>Títol</th>
                <th>Entrada</th>
                <th>Sortida</th>
                <th>Estat</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $registreEntrades as $key => $registreEntrada )
            <tr class="{{ ($registreEntrada->estat == 'Pendent') ? 'bg-warning' : '' }} ">
                <td>{{ $registreEntrada->titol }}</td>
                <td>{{ $registreEntrada->entrada }}</td>
                <td>{{ $registreEntrada->sortida }}</td>
                <td>{{ $registreEntrada->estat }}</td>
                <td>
                    <a href="#" class="btn btn-primary">Modificar</a>
                    <a href="#" class="btn btn-danger">Esborrar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL ESBORRAR REGISSTRE -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar registre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
<!--                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setregistreEntradaPerEsborrar(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="deleteregistreEntrada()">Esborrar</button>
                </div>-->
                </div>
            </div>
        </div>

</div>

<script>
    var registreEntradaPerEsborrar = 0;

    function setregistreEntradaPerEsborrar(registreEntradaId, registreEntradaAlias) {
        registreEntradaPerEsborrar = registreEntradaId;
        if (registreEntradaAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'registreEntrada <b>' + registreEntradaAlias + '</b>?';
        }
    }

    function deleteregistreEntrada() {
        if (registreEntradaPerEsborrar != 0) {
            document.all["delete-" + registreEntradaPerEsborrar].submit(); 
        }
    }
</script>


@stop