@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($actor) ? 'Editar actor' : 'Afegir actor'}}</h2>
    <form method = "POST" action="{{ !empty($actor) ? route('estadilloActorUpdate', array('id' => $estadillos['id_estadillo'], 'id_actor' => $actor['id'])) : route('estadilloActorInsert') }}" enctype="multipart/form-data">
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
                            <option value="{{$empleat['id_empleat']}}" {{(!empty($actor) && $actor->id_actor == $empleat['id_empleat']) ? 'selected' : ''}} >{{$empleat['nom_empleat']}} {{$empleat['cognom1_empleat']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if (isset($estadillos))
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="take_estaillo" style="font-weight: bold">TKs:</label>
                            <input type="number" class="form-control" id="take_estaillo" placeholder="Entrar tks" name="take_estaillo" value="{{!empty($actor) ? $actor->take_estaillo : ''}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="cg_actor" style="font-weight: bold">CGs:</label>
                            <input type="number" class="form-control" id="cg_actor" placeholder="Entrar cgs" name="cg_actor" value="{{!empty($actor) ? $actor->cg_actor : ''}}">
                        </div>
                    </div>
                </div>
            @else
                @foreach ($registreProduccio as $projecte)
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="take_estaillo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['id_sub'] }}:</label>
                                <input type="number" class="form-control" id="take_estaillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estaillo_{{ $projecte['id'] }}" value="{{!empty($actor) ? $actor->take_estaillo : ''}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cg_actor_{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['id_sub'] }}::</label>
                                <input type="number" class="form-control" id="cg_actor_{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_actor_{{ $projecte['id'] }}" value="{{!empty($actor) ? $actor->cg_actor : ''}}">
                            </div>
                        </div>
                    </div>
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
