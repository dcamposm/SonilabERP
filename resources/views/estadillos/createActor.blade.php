@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($actor) ? 'EDITAR ACTOR' : 'AFEGIR ACTOR'}}</h2>
    <form method = "POST" action="{{ !empty($actor) ? ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorUpdate', array('id' => $estadillos['id_estadillo'], 'id_actor' => $actor['id_actor'])) : route('estadilloActorUpdate', array('id' => $registreProduccio[0]['id_registre_entrada'],'id_actor' => $actor['id_actor'], 'setmana' => $registreProduccio[0]['setmana']))) : ( !isset($registreProduccio[0]['setmana']) ? route('estadilloActorInsert') : route('estadilloActorInsert', array('setmana' => $registreProduccio[0]['setmana']))) }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">DADES:</legend>
            <div class="row mb-4 align-items-end">
                @if (isset($estadillos))
                    <div>
                        <input type="text" class="form-control" id="id_produccio" name="id_produccio" value="{{!empty($actor) ? $actor->id_produccio : $estadillos->id_estadillo}}" style="display: none;">
                    </div>
                @endif
                <div class="col-6">
                    <label for="id_actor" style="font-weight: bold">ACTOR:</label>
                    <input required id="selectActor" value="{{!empty($actor) ? $actor->nom_cognom : ''}}" class="form-control"/>
                    <input id="id_actor" class="form-control" name="id_actor" type="hidden" value="{{!empty($actor) ? $actor->id_actor : ''}}">
                </div>
            @if (isset($estadillos))
                <div class="form-group ml-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="canso_estadillo" name="canso_estadillo" {{ !empty($actor) ? ($actor->canso_estadillo == 1 ? 'checked' : '') : ''}} value="1">
                        <label for="canso_estadillo" class="form-check-label" style="font-weight: bold">CANÇÓ</label>      
                    </div>   
                </div>
                <div class="form-group ml-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="narracio_estadillo" name="narracio_estadillo" {{ !empty($actor) ? ($actor->narracio_estadillo == 1 ? 'checked' : '') : ''}} value="1">
                        <label for="narracio_estadillo" class="form-check-label" style="font-weight: bold">NARRACIÓ</label>      
                    </div>   
                </div>
            </div>
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
            </div>
                @foreach ($registreProduccio as $projecte)
                    @if (isset($projecte->getEstadillo))
                        <div class="row">
                            @if (isset($actor))
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="take_estaidllo_{{ $projecte['id'] }}" style="font-weight: bold">TKs Episodi {{ $projecte['subreferencia'] }}:</label>
                                    <input type="number" class="form-control" id="take_estadillo_{{ $projecte['id'] }}" placeholder="Entrar tks" name="take_estadillo_{{ $projecte['id'] }}"
                                        @foreach($projecte->getEstadillo->actors as $actors)
                                            @if ($actors->id_actor == $actor->id_actor)
                                                     value="{{ $actors['take_estadillo']}}"
                                                @break
                                            @endif
                                        @endforeach
                                    >
                                </div>
                                <div class="form-group ml-1 row">
                                    <div class="form-check mr-3">
                                        <input type="checkbox" class="form-check-input" id="canso_estadillo_{{ $projecte['id'] }}" name="canso_estadillo_{{ $projecte['id'] }}" value="1"
                                            @foreach($projecte->getEstadillo->actors as $actors)
                                                @if ($actors->id_actor == $actor->id_actor)
                                                         {{ $actors['canso_estadillo'] == 1 ? 'checked' : ''}}
                                                    @break
                                                @endif
                                            @endforeach   
                                        >
                                        <label for="canso_estadillo_{{ $projecte['id'] }}" class="form-check-label" style="font-weight: bold">CANÇÓ</label>      
                                    </div>   
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="canso_estadillo_{{ $projecte['id'] }}" name="narracio_estadillo_{{ $projecte['id'] }}" value="1"
                                            @foreach($projecte->getEstadillo->actors as $actors)
                                                @if ($actors->id_actor == $actor->id_actor)
                                                         {{ $actors['narracio_estadillo'] == 1 ? 'checked' : ''}}
                                                    @break
                                                @endif
                                            @endforeach   
                                        >
                                        <label for="narracio_estadillo_{{ $projecte['id'] }}" class="form-check-label" style="font-weight: bold">NARRACIÓ</label>      
                                    </div>  
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cg_estadillo_{{ $projecte['id'] }}" style="font-weight: bold">CGs Episodi {{ $projecte['subreferencia'] }}:</label>
                                    <input type="number" class="form-control" id="cg_estadillo_{{ $projecte['id'] }}" placeholder="Entrar cgs" name="cg_estadillo_{{ $projecte['id'] }}"
                                        @foreach($projecte->getEstadillo->actors as $actors)
                                            @if ($actors->id_actor == $actor->id_actor)
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
<script>
    var empleats = @json($empleats);
    @if (isset($empleatsPack))
        var empleatsPack = @json($empleatsPack);
    @endif
    var rutaSearchEmpleat = "{{route('empleatSearch')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/estadilloCreateActor.js') }}"></script>

@endsection
