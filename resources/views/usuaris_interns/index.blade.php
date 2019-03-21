@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{ url('/usuaris/interns/crear') }}" class="btn btn-success">
                <span class="fas fa-user-plus"></span>
                Crear nou usuari
            </a>
        </div>

        <!-- FILTRA USUARI -->
        <div class="row">
            <div class="col">
                <form method = "GET" action= '{{ route('usuariFind') }}' id='search'>
                    @csrf
                <div class="input-group">
                    <select class="custom-select" id='searchBy' name="searchBy" form="search">
                        <option selected>Buscar per...</option>
                        <option>Nom o cognoms</option>
                        <option value="1">Departament</option>
                        <option value="2">Àlies</option>
                    </select>

                    <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar usuari...">

                    <select class="custom-select" id='search_Dep' name="search_Dep" form="search" style="display: none;">
                        @foreach( $departaments as $key => $departament )
                          <option value="{{$departament['id_departament']}}">{{$departament['nom_departament']}}</option>
                        @endforeach
                    </select>

                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">

        @foreach( $arrayUsuaris as $key => $usuaris )
        <div class="card card-shadow text-center m-3" style="min-width: 250px;">

            <div class="card-body" href="{{ url('/usuaris/interns/show/' . $key ) }}" >
                <img src="data:image/jpg;base64,{{$usuaris['imatge_usuari']}}" class="rounded-circle" style="height:150px"/>

                <h4 style="min-height:45px;margin:5px 0 10px 0">
                    <a href="{{ route('veureUsuariIntern', ['id' => $usuaris['id_usuari']]) }}" style="text-decoration:none; color:black; font-size: 1.35rem;">
                        {{$usuaris['nom_usuari']}} {{$usuaris['cognom1_usuari']}}
                    </a>
                </h4>
                <div class="row">
                    <div class="col-6" style="padding: 0px;">
                        <a href="{{ route('editarUsuariIntern', ['id' => $usuaris['id_usuari']]) }}" class="btn btn-outline-primary" style="width: 75%;"> Editar </a>
                    </div>
                    <div class="col-6" style="padding: 0px;">
                        <button onclick="setUsuariPerEsborrar({{$usuaris['id_usuari']}}, '{{$usuaris['alias_usuari']}}')" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter"  style="width: 75%;">Esborrar</button>
                        <form id="delete-{{ $usuaris['id_usuari'] }}" action="{{ route('esborrarUsuariIntern') }}" method="POST">
                            @csrf
                            <input type="hidden" readonly name="id" value="{{$usuaris['id_usuari']}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach

        <!-- MODAL ESBORRAR USUARI -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar usuari</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">Vols esborrar l'usuari </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setUsuariPerEsborrar(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="deleteUsuari()">Esborrar</button>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var usuariPerEsborrar = 0;

    function setUsuariPerEsborrar(userId, userAlias) {
        usuariPerEsborrar = userId;
        if (userAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'usuari <b>' + userAlias + '</b>?';
        }
    }

    function deleteUsuari() {
        if (usuariPerEsborrar != 0) {
            document.all["delete-" + usuariPerEsborrar].submit();
        }
    }
    //--------Funcions per el filtra-----------
    function selectSearch() {
        //var value = $('#searchBy').val();
        
        //alert(value);
        if ($('#searchBy').val() == '1') {
            $('#search_term').hide();
            $('#search_Dep').show();
        } else {
            $('#search_term').show();
            $('#search_Dep').hide();
        }
    }
    
    $('#searchBy').change(selectSearch);   
</script>


@stop
