@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between">
        <div class="col">
            <a href="{{ url('/usuaris/interns/crear') }}" class="btn btn-success mt-1">
                <span class="fas fa-user-plus"></span>
                AFEGIR USUARI
            </a>  
        </div>

        <!-- FILTRA USUARI -->
        <div class="row mt-1">
            <div class="col">
                <form method = "GET" action= '{{ route('usuariFind') }}' id='search'>
                    @csrf
                <div class="input-group">
                    <select class="custom-select" id='searchBy' name="searchBy" form="search">
                        <option value="nom_usuari">BUSCAR PER...</option>
                        <option value="nom_usuari">NOM</option>
                        <option value="cognom1_usuari">COGNOM</option>
                        <option value="id_departament" id="departament">DEPARTAMENT</option>
                        <option value="email_usuariÍndice">EMAIL</option>
                    </select>

                    <input type="text" id="search_term" class="form-control" name="search_term" placeholder="BUSCAR USUARI...">

                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- TABLA D'USUARIS --}}
    <table class="table tableIndex mt-3" style="min-width: 800px;">
        <thead>
            <tr>
                <th>NOM</th> 
                <th>COGNOMS</th>
                <th>EMAIL</th>
                <th>DEPARTAMENT</th>
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $arrayUsuaris as $key => $usuari )
            <tr>
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarUsuari('{{ route('veureUsuariIntern', array('id' => $usuari->id_usuari)) }}')">
                    <span class="font-weight-bold">{{ $usuari->alias_usuari }}</span>
                </td>
                <td style="vertical-align: middle;">{{ $usuari->cognom1_usuari }} {{ $usuari->cognom2_usuari }}</td>
                <td style="vertical-align: middle;">{{ $usuari->email_usuari }}</td>
                <td style="vertical-align: middle;">{{ $usuari->departament->nom_departament }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('editarUsuariIntern', array('id' => $usuari['id_usuari'])) }}" class="btn btn-primary btn-sm"><span style="font-size: 11px;">MODIFICAR</span></a>
                    <button class="btn btn-danger btn-sm" onclick="self.setUsuariPerEsborrar({{ $usuari['id_usuari'] }}, '{{ $usuari['alias_usuari'] }}')" data-toggle="modal" data-target="#exampleModalCenter"><span style="font-size: 11px;">ESBORRAR</span></button>
                    <form id="delete-{{ $usuari['id_usuari'] }}" action="{{ route('esborrarUsuariIntern') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $usuari['id_usuari'] }}">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- MODAL ESBORRAR USUARI -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR USUARI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="delete-message">Vols esborrar l'usuari </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setUsuariPerEsborrar(0)">TANCAR</button>
                <button type="button" class="btn btn-danger" onclick="deleteUsuari()">ESBORRAR</button>
            </div>
            </div>
        </div>
    </div>

    </div>
    @if (Route::currentRouteName() == "usuariFind")
        <a href="{{ url('/usuaris/interns/index') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a> 
    @endif
</div>

<script>
    var departaments = @json($departaments);
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/userIndex.js') }}"></script>

@stop
