@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($actor) ? 'Editar actor' : 'Afegir actor'}}</h2>
    <form method = "POST" action="{{ !empty($actor) ? ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorUpdate', array('id' => $estadillos['id_estadillo'], 'id_actor' => $actor['id'])) : route('estadilloActorUpdate', array('id' => $registreProduccio[0]['id_registre_entrada'],'id_actor' => $actor[0]['id'], 'setmana' => $registreProduccio[0]['setmana']))) : ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorInsert') : route('estadilloActorInsert', array('setmana' => $registreProduccio[0]['setmana']))) }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                @if (isset($estadillos))
                    <div>
                        <input type="text" class="form-control" id="id_estadillo" placeholder="Entrar tks" name="id_estadillo" value="{{!empty($actor) ? $actor->id_estadillo : $estadillos->id_estadillo}}" style="display: none;">
                    </div>
                @endif
                <div class="col-6">
                    <label for="id_actor" style="font-weight: bold">Selecciona actor:</label>
                    <select class="form-control" name="id_actor">
                        @foreach( $empleats as $empleat )
                            <option value="{{$empleat['id_empleat']}}" {{(!empty($actor) && $actor[0]->id_actor == $empleat['id_empleat']) ? 'selected' : ''}} >{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
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
                                @forelse ($projecte->getEstadillo->actors as $actors)
                                    @if ($actors->id_actor == $actor[0]->id_actor)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="take_estaidllo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['id_sub'] }}:</label>
                                                <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}" value="{{ $actors['take_estadillo']}}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cg_estadillo{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['id_sub'] }}:</label>
                                                <input type="number" class="form-control" id="cg_estadillo{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo{{ $projecte['id'] }}" value="{{ $actors['cg_estadillo'] }}">
                                            </div>
                                        </div>
                                        @break
                                    @endif
                                    @empty
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="take_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['id_sub'] }}:</label>
                                                <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cg_estadillo{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['id_sub'] }}:</label>
                                                <input type="number" class="form-control" id="cg_estadillo{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo{{ $projecte['id'] }}">
                                            </div>
                                        </div> 
                                @endforelse
                            @else
                               <div class="col-6">
                                    <div class="form-group">
                                        <label for="take_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['id_sub'] }}:</label>
                                        <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cg_estadillo{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['id_sub'] }}:</label>
                                        <input type="number" class="form-control" id="cg_estadillo{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo{{ $projecte['id'] }}">
                                    </div>
                                </div> 
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($actor) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
    
    <div>
        <a href="/estadillos/mostrar/{{ isset($estadillos) ? $estadillos->id_estadillo : $registreProduccio[0]["id_registre_entrada"]."/".$registreProduccio[0]["setmana"] }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            Tornar enrere
        </a>
    </div>
</div>


@endsection
