@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($idioma) ? 'Editar idioma' : 'Crear idioma'}}</h2>
    <form method = "POST" action="{{ !empty($idioma) ? route('idiomaUpdate', array('id' => $idioma->id_idioma)) : route('idiomaInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="idioma" style="font-weight: bold">Nom:</label>
                        <input type="text" class="form-control" id="idioma" placeholder="Entrar nom" name="idioma" value="{{!empty($idioma) ? $idioma->idioma : ''}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="img_idioma" style="font-weight: bold">Imatge:</label>
                        <input type="file" id="img_idioma" name="img_idioma">
                    </div>
                </div>
            </div>
        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($idioma) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
    
    <div>
        <a href="{{ url('/idiomes') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            Tornar enrere
        </a>
    </div>
</div>


@endsection
