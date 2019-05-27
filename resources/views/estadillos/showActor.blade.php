@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">
        <div class="col mt-1">
            <a href="{{ !isset($registreProduccio) ? route('estadilloActorInsertView', array('id' => $estadillos->id_estadillo)) :  route('estadilloActorInsertView', array('id' => $registreProduccio->id_registre_entrada, 'setmana'=>$registreProduccio->setmana))}}" class="btn btn-success">
                <span class="fas fa-user-tie"></span>
                AFEGIR ACTOR
            </a>
            
            @if (!isset($registreProduccio))
                <button class="btn btn-primary" onclick="self.seleccionarEstadillo({{ $estadillos->id_registre_produccio }}, '{{ $estadillos->id_registre_entrada.' '.$estadillos->titol}}')" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i>
                    IMPORTAR
                </button>
            @endif
        </div>
        <!-- FILTRA Estadillo -->
        <div class="row mt-1">
            <div class="col">
                <form method = "GET" action= '{{ !isset($registreProduccio) ? route('actorFind', array('id' => $estadillos->id_estadillo)) :  route('actorFind', array('id' => $registreProduccio->id_registre_entrada, 'setmana'=>$registreProduccio->setmana))}}' id='search'>
                    @csrf
                <div class="input-group">                 
                    <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar actor...">

                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLA DE ACTORS ESTADILLO --}}
    @if (!isset($registreProduccio))
        <h2 style="font-weight: bold">{{ $estadillos->registreProduccio->id_registre_entrada }} {{ $estadillos->registreProduccio->titol }} {{ $estadillos->registreProduccio->subreferencia }}</h2>
    @else
        <h2 style="font-weight: bold">{{ $estadillos->id_registre_entrada }} {{ $estadillos->titol }} {{ !isset($min) ? '' : ( $min != $max ? $min.'-'.$max : $min) }}</h2>
    @endif
    
    
    <table class="table tableIndex mt-3" style="min-width: 620px;">
        <thead>
            <tr>
                <th>ACTOR</th> 
                <th>CGs TOTALS</th>
                <th>{{isset($actor['id']) ? 'TKs' : 'TKs TOTALS'}}</th>
                <th>NARRACIÓ</th>
                <th>CANÇÓ</th>
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $actors as $key => $actor )
                <tr class="table-selected">
                    @foreach ($empleats as $empleat)
                        @if ($actor['id_actor'] == $empleat->id_empleat)
                            <td style="vertical-align: middle;">
                                <span class="font-weight-bold">{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }}</span>
                            </td>
                            <td style="vertical-align: middle;">{{ $actor['cg_estadillo']}}</td>
                            <td style="vertical-align: middle;">{{ $actor['take_estadillo']}}</td>
                            <td style="vertical-align: middle;">{{ $actor['narracio_estadillo'] == 1 ? 'NARRACIÓ' : ''}}</td>
                            <td style="vertical-align: middle;">{{ $actor['canso_estadillo'] == 1 ? 'CANÇÓ' : ''}}</td>
                            <td style="vertical-align: middle;">
                                <a href="{{ !isset($registreProduccio) ? route('estadilloActorUpdateView', array('id' => $estadillos->id_estadillo, 'id_actor' => $actor['id_actor'])) : route('estadilloActorUpdateView', array('id' => $registreProduccio->id_registre_entrada, 'id_actor'=>$actor['id_actor'], 'setmana'=>$registreProduccio->setmana))  }}" class="btn btn-primary">MODIFICAR</a>
                                @if (isset($actor['id']))
                                <button class="btn btn-danger" onclick="self.seleccionarActor({{ $actor['id'] }}, '{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
                                    <form id="delete-{{ $actor['id'] }}" action="{{ route('esborrarEstadilloActor') }}" method="POST">
                                        @csrf
                                        <input type="hidden" readonly name="id" value="{{ $actor['id'] }}">
                                    </form>
                                @endif
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
         @if (Route::currentRouteName() == "actorFind")
            <a href="{{ url()->previous() }}" class="btn btn-primary mb-3 mt-3">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a>
        @else
            <a href="{{ url('/registreProduccio') }}" class="btn btn-primary mt-3">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a>    
        @endif
    </div>
    
    <!-- MODAL IMPORTAR ESTADILLOS -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">IMPORTAR ESTADILLO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="message"></span>
                    <form action="{{ route('estadilloImport') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="hidden" readonly class="form-control" id="id_estadillo" name="id_estadillo" value=''>
                                <input type="file" class="custom-file-input" name="import_file" id="inputGroupFile" aria-describedby="inputGroupFileAddon">
                                <label class="custom-file-label" for="inputGroupFile">Importar Estadillo</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon">IMPORTAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarEstadillo(0)">TANCAR</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL ESBORRAR ACTOR ESTADILLO -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR ACTOR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarActor(0)">TANCAR</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarActor()">ESBORRAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var self = this;
    self.actorPerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un actor.
    self.mostrarActor = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un actor i mostra un missatge en el modal d'esborrar.
    self.seleccionarActor = function (actorId, actorAlias) {
        self.actorPerEsborrar = actorId;
        if (actorAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el actor <b>' + actorAlias + '</b>?';
        }
    }

    // Esborra el d'un actor seleccionat.
    self.esborrarActor = function () {
        if (self.actorPerEsborrar != 0) {
            document.all["delete-" + self.actorPerEsborrar].submit(); 
        }
    }
    // Finestra modal d'importar.
    self.seleccionarEstadillo = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            $('#id_estadillo').attr('value', registreProduccioId);
            document.getElementById('message').innerHTML = 'Importar estadillo de <b>' + registreProduccioAlias + '</b>:';
        }
    }
</script>


@stop
