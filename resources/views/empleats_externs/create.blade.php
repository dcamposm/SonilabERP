@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($empleat) ? 'Editar usuari' : 'Crear usuari'}}</h2>
    <form method = "POST" action="{{!empty($empleat) ? route('empleatUpdate', ['id' => $empleat->id_empleat]) : route('empleatInsert')}}">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="nom_empleat" style="font-weight: bold">Nom:</label>
                    <input type="text" class="form-control" id="nom_empleat" placeholder="Entrar nom" name="nom_empleat" value="{{!empty($empleat) ? $empleat->nom_empleat : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cognoms_empleat" style="font-weight: bold">Cognoms:</label>
                    <input type="text" class="form-control" id="cognoms_empleat" placeholder="Entrar cognoms" name="cognoms_empleat" value="{{!empty($empleat) ? $empleat->cognoms_empleat : ''}}">
                </div>
            </div>
            
        </div>


        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="sexe_empleat" style="font-weight: bold">Sexe:</label>
                    <select class="form-control" name="sexe_empleat">
                        <option value="Dona" {{(!empty($empleat) && $empleat->sexe_empleat == 'Dona') ? 'selected' : ''}}>Dona</option>
                        <option value="Home" {{(!empty($empleat) && $empleat->sexe_empleat == 'Home') ? 'selected' : ''}}>Home</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="nacionalitat" style="font-weight: bold">Nacionalitat:</label>
                    <input type="text" class="form-control" id="nacionalitat_empleat" placeholder="Entrar nacionalitat" name="nacionalitat_empleat" value="{{!empty($empleat) ? $empleat->nacionalitat_empleat : ''}}">
                </div>
            </div>
            
        </div>
        <!-- POR AQUI IMAGEN -->
        <div class="row">
            <!-- <div class="col-6">
                <div class="form-group">
                    <label for="imatge_empleat" style="font-weight: bold">Alias:</label>
                    <input type="text" class="form-control" id="alias_usuari" placeholder="Entrar alias" name="alias_usuari" value="{{!empty($empleat) ? $empleat->alias_empleat : ''}}">
                </div>
            </div> -->

            <div class="col-6">
                <div class="form-group">
                    <label for="email_empleat" style="font-weight: bold">Email:</label>
                    <input type="email" class="form-control" id="email_empleat" placeholder="Entrar correu" name="email_empleat" value="{{!empty($empleat) ? $empleat->email_empleat : ''}}">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="dni_empleat" style="font-weight: bold">DNI:</label>
                    <input type="text" class="form-control" id="dni_empleat" placeholder="Entrar DNI empleat" name="dni_empleat" value="{{!empty($empleat) ? $empleat->dni_empleat : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="telefon_empleat" style="font-weight: bold">Telèfon:</label>
                    <input type="tel" class="form-control" id="telefon_empleat" placeholder="Entrar telèfon empleat" name="telefon_empleat" value="{{!empty($empleat) ? $empleat->telefon_empleat : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="direccio_empleat" style="font-weight: bold">Direcció:</label>
                    <input type="text" class="form-control" id="direccio_empleat" placeholder="Entrar direcció empleat" name="direccio_empleat" value="{{!empty($empleat) ? $empleat->direccio_empleat : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="codi_postal_empleat" style="font-weight: bold">Codi postal:</label>
                    <input type="number" class="form-control" id="codi_postal_empleat" placeholder="Entrar codi postal empleat" name="codi_postal_empleat" value="{{!empty($empleat) ? $empleat->codi_postal_empleat : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="naixement_empleat" style="font-weight: bold">Data naixement:</label>
                    <input type="date" class="form-control" id="naixement_empleat" placeholder="Entrar data naixement empleat" name="naixement_empleat" value="{{!empty($empleat) ? explode(' ',$empleat->naixement_empleat)[0] : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="nss_empleat" style="font-weight: bold">NSS:</label>
                    <input type="number" class="form-control" id="nss_empleat" placeholder="Entrar número seguretat social empleat" name="nss_empleat" value="{{!empty($empleat) ? $empleat->nss_empleat : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="iban_empleat" style="font-weight: bold">IBAN:</label>
                    <input type="text" class="form-control" id="iban_empleat" placeholder="Entrar IBAN empleat" name="iban_empleat" value="{{!empty($empleat) ? $empleat->iban_empleat : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="actor" style="font-weight: bold">Actor:</label>
                    <input type="checkbox" class="form-control" id="actor" name="actor" {{!empty($empleat) && $empleat->actor == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="director" style="font-weight: bold">Director:</label>
                    <input type="checkbox" class="form-control" id="director" name="director" {{!empty($empleat) && $empleat->director == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="tecnic_sala" style="font-weight: bold">Técnic:</label>
                    <input type="checkbox" class="form-control" id="tecnic_sala" name="tecnic_sala" {{!empty($empleat) && $empleat->tecnic_sala == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="traductor" style="font-weight: bold">Traductor:</label>
                    <input type="checkbox" class="form-control" id="traductor" name="traductor" {{!empty($empleat) && $empleat->traductor == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="ajustador" style="font-weight: bold">Ajustador:</label>
                    <input type="checkbox" class="form-control" id="ajustador" name="ajustador" {{!empty($empleat) && $empleat->ajustador == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="linguista" style="font-weight: bold">Lingüista:</label>
                    <input type="checkbox" class="form-control" id="linguista" name="linguista" {{!empty($empleat) && $empleat->linguista == 1 ? 'checked' : ''}} value="1">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_actor" style="font-weight: bold">Preu actor:</label>
                    <input type="number" class="form-control" id="preu_actor" placeholder="Entrar preu actor" name="preu_actor" value="{{!empty($empleat) ? $empleat->preu_actor : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_director" style="font-weight: bold">Preu director:</label>
                    <input type="number" class="form-control" id="preu_director" placeholder="Entrar preu director" name="preu_director" value="{{!empty($empleat) ? $empleat->preu_director : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_tecnicSala" style="font-weight: bold">Preu técnic de sala:</label>
                    <input type="number" class="form-control" id="preu_tecnicSala" placeholder="Entrar preu técnic de Sala" name="preu_tecnic_sala" value="{{!empty($empleat) ? $empleat->preu_tecnic_sala : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_traductor" style="font-weight: bold">Preu traductor:</label>
                    <input type="number" class="form-control" id="preu_traductor" placeholder="Entrar preu traductor" name="preu_traductor" value="{{!empty($empleat) ? $empleat->preu_traductor : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_ajustador" style="font-weight: bold">Preu ajustador:</label>
                    <input type="number" class="form-control" id="preu_ajustador" placeholder="Entrar preu ajustador" name="preu_ajustador" value="{{!empty($empleat) ? $empleat->preu_ajustador : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_linguista" style="font-weight: bold">Preu lingüista:</label>
                    <input type="number" class="form-control" id="preu_linguista" placeholder="Entrar preu lingüista" name="preu_linguista" value="{{!empty($empleat) ? $empleat->preu_linguista : ''}}">
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($empleat) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
</div>

@endsection
