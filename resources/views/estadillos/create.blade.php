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
                    <div class="form-group">
                        <label for="id_registre_entrada" style="font-weight: bold">Numero de referencia:</label>
                        <input type="text" class="form-control" id="id_registre_entrada" placeholder="Entrar numero de referencia" name="id_registre_entrada" value="{{!empty($estadillos) ? $estadillos->id_registre_entrada : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="id_registre_produccio" style="font-weight: bold">Numero de sub-referencia:</label>
                        <input type="text" class="form-control" id="id_registre_produccio" placeholder="Entrar numero de sub-referencia" name="id_registre_produccio" value="{{!empty($estadillos) ? $estadillos->id_registre_produccio : ''}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="tipus_media" style="font-weight: bold">Selecciona tipus:</label>
                    <select class="form-control" name="tipus_media">
                        @foreach( $medias as $media )
                            <option value="{{$media['id_media']}}" {{(!empty($estadillos) && $estadillos->tipus_media == $media['id_media']) ? 'selected' : ''}} >{{$media['nom_media']}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-6">
                    <label for="validat" style="font-weight: bold">Validat:</label>
                    <select class="form-control" name="validat">
                        <option value="0" {{(!empty($estadillos) && $estadillos->validat == '0') ? 'selected' : ''}}>No</option>
                        <option value="1" {{(!empty($estadillos) && $estadillos->validat == '1') ? 'selected' : ''}}>Si</option>
                    </select>
                </div>
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
</div>


@endsection
