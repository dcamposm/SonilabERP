@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
      
        <div class="col">
            @if (Auth::user()->hasAnyRole(['1', '4']))
            <a href="{{ url('/empleats/crear') }}" class="btn btn-success">
                <span class="fas fa-user-plus"></span>
                AFEGIR TREBALLADOR
            </a>
            @endif
        </div>
      
      <!-- FILTRA EMPLEAT -->
        <div class="row">
            <div class="col">
                <form method = "GET" action= '{{ route('empleatFind') }}' id='search'>
                    @csrf
                <div class="input-group">
                    <select class="custom-select" id='searchBy' name="searchBy" form="search">
                        <option selected>BUSCAR PER...</option>
                        <option>NOM O COGNOM</option>
                        <option value="1">CÀRREC</option>
                        <option value="2">SEXE</option>
                        <option value="3">NACIONALITAT</option>
                    </select>

                    <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar treballador...">

                    <select class="custom-select" id='search_Carrec' name="search_Carrec" form="search" style="display: none;">
                        @foreach( $carrecs as $key => $carrec )
                          <option value="{{$carrec['id_carrec']}}">{{ mb_strtoupper( $carrec['descripcio_carrec'] ) }}</option>
                        @endforeach
                    </select>
                    <select class="custom-select" id='search_Sexe' name="search_Sexe" form="search" style="display: none;">
                          <option value="Dona">DONA</option>
                          <option value="Home">HOME</option>
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
  </div>
    
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>NOM</th> 
                <th>COGNOMS</th>
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
                    <td style="vertical-align: middle;">{{$empleat['cognom1_empleat']}} {{$empleat['cognom2_empleat']}}</td>
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
                    @endif
                </tr>
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
    @if (isset($return))
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
        //var value = $('#searchBy').val();
        
        //alert(value);
        if ($('#searchBy').val() == '1') {
            $('#search_term').hide();
            $('#search_Sexe').hide();
            $('#search_Carrec').show();
        } else if ($('#searchBy').val() == '2') {
            $('#search_term').hide();
            $('#search_Sexe').show();
            $('#search_Carrec').hide();
        } 
        else {
            $('#search_term').show();
            $('#search_Sexe').hide();
            $('#search_Carrec').hide();
        }
    }
    
    $('#searchBy').change(selectSearch);  
</script>


@stop
