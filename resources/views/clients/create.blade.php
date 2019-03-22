@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($client) ? 'Editar client' : 'Crear client'}}</h2>
    <form method = "POST" action="{{ !empty($client) ? route('clientUpdate', array('id' => $client->id_client)) : route('clientInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="nom_client" style="font-weight: bold">Nom:</label>
                        <input type="text" class="form-control" id="nom_client" placeholder="Entrar nom" name="nom_client" value="{{!empty($client) ? $client->nom_client : old('nom_client')}}">
                        <span class="text-danger">{{ $errors->first('nom_client') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email_client" style="font-weight: bold">Email:</label>
                        <input type="email" class="form-control" id="email_client" placeholder="Entrar email" name="email_client" value="{{!empty($client) ? $client->email_client : old('email_client')}}">
                        <span class="text-danger">{{ $errors->first('email_client') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="telefon_client" style="font-weight: bold">Telefon:</label>
                        <input type="text" class="form-control" id="telefon_client" placeholder="Entrar telefon" name="telefon_client" value="{{!empty($client) ? $client->telefon_client : ''}}">
                        <span class="text-danger">{{ $errors->first('telefon_client') }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="direccio_client" style="font-weight: bold">Direcció:</label>
                        <input type="text" class="form-control" id="direccio_client" placeholder="Entrar direcció" name="direccio_client" value="{{!empty($client) ? $client->direccio_client : ''}}">
                        <span class="text-danger">{{ $errors->first('direccio_client') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="codi_postal_client" style="font-weight: bold">Codi postal:</label>
                        <input type="number" class="form-control" id="codi_postal_client" placeholder="Entrar codi postal" name="codi_postal_client" value="{{!empty($client) ? $client->codi_postal_client : ''}}">
                        <span class="text-danger">{{ $errors->first('codi_postal_client') }}</span>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="ciutat_client" style="font-weight: bold">Ciutat:</label>
                        <input type="text" class="form-control" id="ciutat_client" placeholder="Entrar ciutat" name="ciutat_client" value="{{!empty($client) ? $client->ciutat_client : ''}}">
                        <span class="text-danger">{{ $errors->first('ciutat_client') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="pais_client" style="font-weight: bold">Pais:</label>
                        <input type="text" class="form-control" id="pais_client" placeholder="Entrar pais" name="pais_client" value="{{!empty($client) ? $client->pais_client : ''}}">
                        <span class="text-danger">{{ $errors->first('pais_client') }}</span>
                    </div>
                </div>
            </div>
        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($client) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
    
    <div>
        <a href="{{ url('/clients') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            Tornar enrera
        </a>
    </div>
</div>


@endsection
