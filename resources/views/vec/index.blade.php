@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div>
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
        <button class="btn btn-success" data-toggle="modal" data-target="#ModalInsert">
            <span class="fas fa-clipboard-list"></span>CREAR VALORACIÓ ECONÒMICA
        </button>
    </div>
    <br>
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
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarVec('{{ route('mostrarVec', array('id' => $vec->id_costos)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $vec->registreProduccio->id_registre_entrada }}</span>
                </td>
                <td style="vertical-align: middle;">{{ $vec->registreProduccio->registreEntrada->titol }}</td>
                <td style="vertical-align: middle;">{{ $vec->registreProduccio->registreEntrada->client->nom_client }}</td>
                <td style="vertical-align: middle;">{{ $vec->registreProduccio->subreferencia == 0 ? '' : $vec->registreProduccio->subreferencia }}</td>
                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($vec->registreProduccio->data_entrega)) }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('vecUpdateView', array('id' => $vec['id_costos'])) }}" class="btn btn-primary">MODIFICAR</a>
                    <button class="btn btn-danger" onclick="self.seleccionarVec({{ $vec['id_costos'] }}, '{{ $vec->registreProduccio->id_registre_entrada.' '.$vec->registreProduccio->titol.' '.$vec->registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                    <form id="delete-{{ $vec['id_costos'] }}" action="{{ route('esborrarVec') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $vec['id_costos'] }}">
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
    
    <!-- MODAL CREAR VEC -->
    <div class="modal fade" id="ModalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">CREAR VALORACIÓ ECONÒMICA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method = "POST" action="{{ route('vecInsert') }}" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="border p-2">
                        <legend class="w-auto">DADES:</legend>
                        <div class="row">
                            <div class="col">
                                <label for="id_registre_produccio" style="font-weight: bold">REGISTRE:</label>
                                <select class="form-control" name="id_registre_produccio">
                                    @foreach( $registreProduccio as $projecte )
                                        <option value="{{$projecte['id']}}">{{$projecte['id_registre_entrada']}} {{$projecte['titol']}} {{$projecte['subreferencia']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                
                </div>
                <div class="modal-footer justify-content-between mt-3">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">TANCAR</button>
                    <button type="submit" class="btn btn-success col-4">CREAR</button>
                </div>
                </form>
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
