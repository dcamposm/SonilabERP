@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div class="col">
            <a href="{{ !isset($registreProduccio) ? route('estadilloActorInsertView', array('id' => $estadillos->id_estadillo)) :  route('estadilloActorInsertView', array('id' => $registreProduccio->id_registre_entrada, 'setmana'=>$registreProduccio->setmana))}}" class="btn btn-success">
                <span class="fas fa-user-tie"></span>
                AFEGIR ACTOR
            </a>
        </div>

        <!-- FILTRA Estadillo -->
        <div class="row">
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
    
    <br>
    {{-- TABLA DE ACTORS ESTADILLO --}}
    <h2 style="font-weight: bold">{{ $estadillos->id_registre_entrada }} {{ $estadillos->titol }} {{ !isset($min) ? '' : ( $min != $max ? $min.'-'.$max : $min) }}</h2>
    
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>ACTOR</th> 
                <th>CGs</th>
                <th>{{isset($actor['id']) ? 'TKs' : 'TKs TOTALS'}}</th>
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $actors as $key => $actor )
            <tr class="table-selected">
                @foreach ($empleats as $empleat)
                    @if ($actor['id_actor'] == $empleat->id_empleat)
                        <td style="vertical-align: middle;">

                                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }}</span>

                        </td>
                        <td style="vertical-align: middle;">{{ $actor['cg_estadillo']}}</td>
                        <td style="vertical-align: middle;">{{ $actor['take_estadillo']}}</td>
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
    <br>
    <div>
        <a href="{{ url('/estadillos') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
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
</script>


@stop
