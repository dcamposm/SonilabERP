@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($actor) ? 'EDITAR ACTOR' : 'AFEGIR ACTOR'}}</h2>
    <form method = "POST" action="{{ !empty($actor) ? ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorUpdate', array('id' => $estadillos['id_estadillo'], 'id_actor' => $actor['id_actor'])) : route('estadilloActorUpdate', array('id' => $registreProduccio[0]['id_registre_entrada'],'id_actor' => $actor[0]['id'], 'setmana' => $registreProduccio[0]['setmana']))) : ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorInsert') : route('estadilloActorInsert', array('setmana' => $registreProduccio[0]['setmana']))) }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">DADES:</legend>
            <div class="row mb-4">
                @if (isset($estadillos))
                    <div>
                        <input type="text" class="form-control" id="id_produccio" placeholder="Entrar tks" name="id_produccio" value="{{!empty($actor) ? $actor->id_produccio : $estadillos->id_estadillo}}" style="display: none;">
                    </div>
                @endif
                <div class="col-6">
                    <label for="id_actor" style="font-weight: bold">ACTOR:</label>
                    <select class="form-control" name="id_actor">
                        @foreach( $empleats as $empleat )
                            <option value="{{$empleat['id_empleat']}}" {{(!empty($actor) && ($actor[0]->id_actor ?? $actor->id_actor) == $empleat['id_empleat']) ? 'selected' : ''}} >{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if (isset($estadillos))
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="take_estadillo" style="font-weight: bold">TKs:</label>
                            <input type="number" class="form-control" id="take_estadillo" placeholder="Entrar tks" name="take_estadillo" value="{{!empty($actor) ? $actor->take_estadillo : ''}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cg_estadillo" style="font-weight: bold">CGs:</label>
                            <input type="number" class="form-control" id="cg_estadillo" placeholder="Entrar cgs" name="cg_estadillo" value="{{!empty($actor) ? $actor->cg_estadillo : ''}}">
                        </div>
                    </div>
                </div>
            @else
                @foreach ($registreProduccio as $projecte)
                    @if (isset($projecte->getEstadillo))
                        <div class="row">
                            @if (isset($actor))
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="take_estaidllo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['subreferencia'] }}:</label>
                                    <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}"
                                        @foreach($projecte->getEstadillo->actors as $actors)
                                            @if ($actors->id_actor == $actor[0]->id_actor)
                                                     value="{{ $actors['take_estadillo']}}"
                                                @break
                                            @endif
                                        @endforeach
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cg_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['subreferencia'] }}:</label>
                                    <input type="number" class="form-control" id="cg_estadillo_{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo_{{ $projecte['id'] }}"
                                        @foreach($projecte->getEstadillo->actors as $actors)
                                            @if ($actors->id_actor == $actor[0]->id_actor)
                                                value="{{ $actors['cg_estadillo'] }}"
                                            @endif
                                        @endforeach
                                    >
                                </div>
                            </div>
                            @else
                               <div class="col-6">
                                    <div class="form-group">
                                        <label for="take_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['subreferencia'] }}:</label>
                                        <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cg_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['subreferencia'] }}:</label>
                                        <input type="number" class="form-control" id="cg_estadillo_{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo_{{ $projecte['id'] }}">
                                    </div>
                                </div> 
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </fieldset>

        <div class="row justify-content-between mt-4 mb-4">
            <a href="/estadillos/mostrar/{{ isset($estadillos) ? $estadillos->id_estadillo : $registreProduccio[0]["id_registre_entrada"]."/".$registreProduccio[0]["setmana"] }}" class="btn btn-primary">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a> 
            <button type="submit" class="btn btn-success col-2">{{!empty($actor) ? 'DESAR' : 'CREAR'}}</button>     
        </div>

    </form>

</div>


@endsection
