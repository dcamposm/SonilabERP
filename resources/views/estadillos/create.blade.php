@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($estadillos) ? 'Editar estadillo' : 'Crear estadillo'}}</h2>
    <form method = "POST" action="{{ !empty($estadillos) ? route('estadilloUpdate', array('id' => $estadillos->id_estadillo)) : route('estadilloInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                <div class="col-6">
                    <label for="id_registre_produccio" style="font-weight: bold">Selecció del registre:</label>
                    <select class="form-control" name="id_registre_produccio">
                        @foreach( $registreProduccio as $projecte )
                            <option value="{{$projecte['id']}}" {{(!empty($estadillos) && $estadillos->id_registre_produccio == $projecte['id']) ? 'selected' : ''}} >{{$projecte['id_registre_entrada']}} {{$projecte['titol']}} {{$projecte['subreferencia']}} </option>
                        @endforeach
                    </select>
                </div>
                
                @if (isset($estadillos))
                    <div class="col-6">
                        <label for="validat" style="font-weight: bold">Validat:</label>
                        <select class="form-control" name="validat">
                            <option value="0" {{$registre->estadillo == '0' ? 'selected' : ''}}>No</option>
                            <option value="1" {{$registre->estadillo == '1' ? 'selected' : ''}}>Si</option>
                        </select>
                    </div>
                @endif
            </div>
        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($estadillos) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
    
    <div>
        <a href="{{ route('indexEstadillos') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            Tornar enrera
        </a>
    </div>
</div>


@endsection
