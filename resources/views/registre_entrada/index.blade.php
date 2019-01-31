@extends('layouts.app')

@section('content')

<div>
<!--    <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">-->
    <a href="#" class="btn btn-success">
        <span class="fas fa-atlas"></span>
        Afegir registre d'entrada
    </a>
</div>

<div class="row">

    {{-- TODO: Realizar la vista principal. Usar la variable $registreEntrades para coger los registros de entrada. --}}

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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setEmpleatPerEsborrar(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="deleteEmpleat()">Esborrar</button>
                </div>-->
                </div>
            </div>
        </div>

</div>

<script>
    var empleatPerEsborrar = 0;

    function setEmpleatPerEsborrar(empleatId, empleatAlias) {
        empleatPerEsborrar = empleatId;
        if (empleatAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'empleat <b>' + empleatAlias + '</b>?';
        }
    }

    function deleteEmpleat() {
        if (empleatPerEsborrar != 0) {
            document.all["delete-" + empleatPerEsborrar].submit(); 
        }
    }
</script>


@stop