@extends('layouts.app')

@section('content')

<div>
    <a href="{{ url('/registreEntrada/crear') }}" class="btn btn-success">
        <span class="fas fa-atlas"></span>
        Afegir registre d'entrada
    </a>
</div>

<div class="row">

<<<<<<< HEAD
   {{-- @foreach( $registreEntradas as $key => $registreEntrada )

    <div class="card card-shadow text-center m-3" style="min-width: 250px;">

        <div class="card-body">
            <img src="data:image/jpg;base64,{{$registreEntrada['imatge_registreEntrada']}}" class="rounded-circle" style="height:150px"/>
            
            <h4 style="min-height:45px;margin:5px 0 10px 0">
                <a href="{{ route('registreEntradaShow', ['id' => $registreEntrada['id_registreEntrada']]) }}" style="text-decoration:none; color:black; font-size: 1.35rem;">
                    {{$registreEntrada['nom_registreEntrada']}} {{$registreEntrada['cognom1_registreEntrada']}} 
                </a>
            </h4>
            <div class="row">
                <div class="col-6" style="padding: 0px;">
                    <a href="{{ route('registreEntradaUpdateView', ['id' => $registreEntrada['id_registreEntrada']]) }}" class="btn btn-outline-primary" style="width: 75%;"> Editar </a> 
                </div>
                <div class="col-6" style="padding: 0px;">
                    <button onclick="setregistreEntradaPerEsborrar({{$registreEntrada['id_registreEntrada']}}, '{{$registreEntrada['nom_registreEntrada']}} {{$registreEntrada['cognom1_registreEntrada']}} {{$registreEntrada['cognom2_registreEntrada']}}')" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter"  style="width: 75%;">Esborrar</button>
                    <form id="delete-{{ $registreEntrada['id_registreEntrada'] }}" action="{{ route('registreEntradaDelete') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{$registreEntrada['id_registreEntrada']}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach --}}
=======
    {{-- TODO: Realizar la vista principal. Usar la variable $registreEntrades para coger los registros de entrada. --}}
>>>>>>> adbb63b2c063c2abd269665707f67e926c4ab63c

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