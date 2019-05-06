@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($client) ? 'EDITAR CLIENT' : 'CREAR CLIENT'}}</h2>
    <form method = "POST" action="{{ !empty($client) ? route('clientUpdate', array('id' => $client->id_client)) : route('clientInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2 mb-4">
            <legend class="w-auto">DADES:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="nom_client" style="font-weight: bold">NOM:</label>
                        <input type="text" class="form-control" id="nom_client" placeholder="Entrar nom" name="nom_client" value="{{!empty($client) ? $client->nom_client : old('nom_client')}}">
                        <span class="text-danger">{{ $errors->first('nom_client') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nif_client" style="font-weight: bold">NIF:</label>
                        <input type="text" class="form-control" id="nif_client" placeholder="Entrar nif" name="nif_client" value="{{!empty($client) ? $client->nif_client : old('nif_client')}}">
                        <span class="text-danger">{{ $errors->first('nif_client') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email_client" style="font-weight: bold">EMAIL:</label>
                        <input type="email" class="form-control" id="email_client" placeholder="Entrar email" name="email_client" value="{{!empty($client) ? $client->email_client : old('email_client')}}">
                        <span class="text-danger">{{ $errors->first('email_client') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="telefon_client" style="font-weight: bold">TELÈFON:</label>
                        <input type="text" class="form-control" id="telefon_client" placeholder="Entrar telefon" name="telefon_client" value="{{!empty($client) ? $client->telefon_client : old('telefon_client')}}">
                        <span class="text-danger">{{ $errors->first('telefon_client') }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="direccio_client" style="font-weight: bold">DIRECCIÓ:</label>
                        <input type="text" class="form-control" id="direccio_client" placeholder="Entrar direcció" name="direccio_client" value="{{!empty($client) ? $client->direccio_client : old('direccio_client')}}">
                        <span class="text-danger">{{ $errors->first('direccio_client') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="codi_postal_client" style="font-weight: bold">CODI POSTAL:</label>
                        <input type="number" class="form-control" id="codi_postal_client" placeholder="Entrar codi postal" name="codi_postal_client" value="{{!empty($client) ? $client->codi_postal_client : old('codi_postal_client')}}">
                        <span class="text-danger">{{ $errors->first('codi_postal_client') }}</span>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="ciutat_client" style="font-weight: bold">CIUTAT:</label>
                        <input type="text" class="form-control" id="ciutat_client" placeholder="Entrar ciutat" name="ciutat_client" value="{{!empty($client) ? $client->ciutat_client : old('ciutat_client')}}">
                        <span class="text-danger">{{ $errors->first('ciutat_client') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="pais_client" style="font-weight: bold">PAIS:</label>
                        <input type="text" class="form-control" id="pais_client" placeholder="Entrar pais" name="pais_client" value="{{!empty($client) ? $client->pais_client : old('pais_client')}}">
                        <span class="text-danger">{{ $errors->first('pais_client') }}</span>
                    </div>
                </div>
            </div>
        </fieldset>


        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row justify-content-between">
            <a href="{{ url('/clients') }}" class="btn btn-primary col-2">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a>

            <button type="submit" class="btn btn-success col-2">{{!empty($client) ? 'DESAR' : 'CREAR'}} <i class="fas fa-save"></i></button>
        </div>
    </form>
</div>


@endsection
