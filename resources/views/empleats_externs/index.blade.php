@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
        <div class="col">
            @if (Auth::user()->hasAnyRole(['1', '4']))
            <a href="{{ url('/empleats/crear') }}" class="btn btn-success mt-1">
                <span class="fas fa-user-plus"></span>
                AFEGIR TREBALLADOR
            </a>
            @endif
        </div>
      
      <!-- FILTRA EMPLEAT -->
        <div class="row mt-1">
            <div class="col">
                <form method = "GET" action= '{{ route('empleatFind') }}' id='search'>
                    @csrf
                <div class="input-group">
                    <select class="custom-select" id='searchBy' name="searchBy" form="search">
                        <option value="nom_empleat" selected>BUSCAR PER...</option>
                        <option value="nom_empleat">NOM</option>
                        <option value="cognom1_empleat">COGNOM</option>
                        <option value="carrec" id="carrec">CÀRREC</option>
                        <option value="sexe_empleat" id="sexe">SEXE</option>
                        <option value="nacionalitat_empleat">NACIONALITAT</option>
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
    
    <table class="table tableIndex mt-3" style="min-width: 1000px;">
        <thead>
            <tr>
                <th>NOM</th> 
                <th>COGNOM</th>
                <th>TELÈFON</th>
                <th>CARRECS</th>
                @if (Auth::user()->hasAnyRole(['1', '4']))
                <th>ACCIONS</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach( $empleats as $key => $empleat )
                <tr>
                    <td style="vertical-align: middle;"><a class="font-weight-bold" href="{{ route('empleatShow', ['id' => $empleat['id_empleat']]) }}" style="text-decoration:none; color:black;">{{$empleat['nom_empleat']}} </a></td>
                    <td style="vertical-align: middle;">{{$empleat['cognom1_empleat']}}</td>
                    <td style="vertical-align: middle;">{{$empleat['telefon_empleat']}}</td>
                    <td style="padding: 0px;">
                        <ul class="list-group list-group-horizontal-sm" style="flex-direction: row;">
                        @foreach( $empleatsArray as $key => $empCarrec )
                            @if ($key == $empleat->id_empleat)
                                @foreach( $empCarrec as $key2 => $carrec )
                                    <li class="list-group-item" style="border-top: none; border-bottom: none;">{{$carrec}}</li>
                                @endforeach
                            @endif
                        @endforeach
                        </ul>
                    </td>
                    @if (Auth::user()->hasAnyRole(['1', '4']))
                        <td style="vertical-align: middle;">
                            <a href="{{ route('empleatUpdateView', ['id' => $empleat['id_empleat']]) }}" class="btn btn-primary"> MODIFICAR </a>
                            <button onclick="setEmpleatPerEsborrar({{$empleat['id_empleat']}}, '{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}} {{$empleat['cognom2_empleat']}}')" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                            <form id="delete-{{ $empleat['id_empleat'] }}" action="{{ route('empleatDelete') }}" method="POST">
                                @csrf
                                <input type="hidden" readonly name="id" value="{{$empleat['id_empleat']}}">
                            </form>
                        </td>
                        @if (Auth::user()->hasAnyRole(['1', '4']))
                            <td style="vertical-align: middle;">
                                <a href="{{ route('empleatUpdateView', ['id' => $empleat['id_empleat']]) }}" class="btn btn-primary"> MODIFICAR </a>
                                <button onclick="setEmpleatPerEsborrar({{$empleat['id_empleat']}}, '{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}} {{$empleat['cognom2_empleat']}}')" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                                <form id="delete-{{ $empleat['id_empleat'] }}" action="{{ route('empleatDelete') }}" method="POST">
                                    @csrf
                                    <input type="hidden" readonly name="id" value="{{$empleat['id_empleat']}}">
                                </form>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- MODAL ESBORRAR EMPLEAT -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR EMPLEAT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="delete-message">...</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setEmpleatPerEsborrar(0)">TANCAR</button>
                <button type="button" class="btn btn-danger" onclick="deleteEmpleat()">ESBORRAR</button>
            </div>
            </div>
        </div>
    </div>
    @if (Route::currentRouteName() == "empleatFind")
        <a href="{{ url('/empleats') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
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
    
    //--------Funcions per el filtra-----------
    function selectSearch() {
        if ($('#searchBy').children(":selected").attr("id") == 'carrec') {
            $('#search_term').remove();
        
            var select = document.createElement("select");
            $(select).attr("name", "search_term");
            $(select).attr("id", "search_term");
            $(select).attr("class", "form-control");

            var carrecs = @json($carrecs);

            $.each(carrecs, function( key, carrec ) {
                $(select).append('<option value="'+carrec['id_carrec']+'">'+carrec['descripcio_carrec'].toUpperCase()+'</option>');
            });

            $(select).insertAfter('#searchBy');
        } else if ($('#searchBy').children(":selected").attr("id") == 'sexe'){
            $('#search_term').remove();
        
            var select = document.createElement("select");
            $(select).attr("name", "search_term");
            $(select).attr("id", "search_term");
            $(select).attr("class", "form-control");
            $(select).append('<option value="Dona">DONA</option>');
            $(select).append('<option value="Home">HOME</option>');
            
            $(select).insertAfter('#searchBy');
        } else {
            $('#search_term').remove();
            $('<input type="text" class="form-control" id="search_term" name="search_term" placeholder="Buscar treballador...">').insertAfter('#searchBy');
        }
    }
    
    $('#searchBy').change(selectSearch);  
</script>


@stop
