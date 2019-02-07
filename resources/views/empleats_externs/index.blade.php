@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <a href="{{ url('/empleats/crear') }}" class="btn btn-success">
            <span class="fas fa-user-plus"></span>
            Afegir treballador
        </a>    
    </div>
    
    <!-- FILTRA EMPLEAT -->
    <div class="row">    
        <div class="col">
            <form method = "GET" action= '{{ route('empleatFind') }}' id='search'>
                @csrf
            <div class="input-group">   
                <select class="custom-select" id='searchBy' name="searchBy" form="search">
                    <option selected>Buscar per...</option>
                    <option>Nom o cognoms</option>
                    <option value="1">Carrec</option>
                    <option value="2">Sexe</option>
                    <option value="3">Nacionalitat</option>
                </select>
                <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar treballador...">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                </span>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="row">

    @foreach( $empleats as $key => $empleat )

    <div class="card card-shadow text-center m-3" style="min-width: 250px;">

        <div class="card-body">
            <img src="data:image/jpg;base64,{{$empleat['imatge_empleat']}}" class="rounded-circle" style="height:150px"/>
            
            <h4 style="min-height:45px;margin:5px 0 10px 0">
                <a href="{{ route('empleatShow', ['id' => $empleat['id_empleat']]) }}" style="text-decoration:none; color:black; font-size: 1.35rem;">
                    {{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}} 
                </a>
            </h4>
            <div class="row">
                <div class="col-6" style="padding: 0px;">
                    <a href="{{ route('empleatUpdateView', ['id' => $empleat['id_empleat']]) }}" class="btn btn-outline-primary" style="width: 75%;"> Editar </a> 
                </div>
                <div class="col-6" style="padding: 0px;">
                    <button onclick="setEmpleatPerEsborrar({{$empleat['id_empleat']}}, '{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}} {{$empleat['cognom2_empleat']}}')" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter"  style="width: 75%;">Esborrar</button>
                    <form id="delete-{{ $empleat['id_empleat'] }}" action="{{ route('empleatDelete') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{$empleat['id_empleat']}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach

    <!-- MODAL ESBORRAR EMPLEAT -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar empleat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setEmpleatPerEsborrar(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="deleteEmpleat()">Esborrar</button>
                </div>
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