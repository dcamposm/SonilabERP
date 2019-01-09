@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($empleat) ? 'Editar usuario' : 'Crear usuario'}}</h2>
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
                        <option value="Dona">Dona</option>
                        <option value="Home">Home</option>
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
                    <label for="dni_empleat" style="font-weight: bold">Dni:</label>
                    <input type="text" class="form-control" id="dni_empleat" placeholder="Entrar dni empleat" name="dni_empleat">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="telefon_empleat" style="font-weight: bold">Telefon:</label>
                    <input type="tel" class="form-control" id="telefon_empleat" placeholder="Entrar telefon empleat" name="telefon_empleat">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="direccio_empleat" style="font-weight: bold">Direccio:</label>
                    <input type="text" class="form-control" id="direccio_empleat" placeholder="Entrar direccio empleat" name="direccio_empleat">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="codi_postal_empleat" style="font-weight: bold">Codi postal:</label>
                    <input type="number" class="form-control" id="codi_postal_empleat" placeholder="Entrar codi postal empleat" name="codi_postal_empleat">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="naixement_empleat" style="font-weight: bold">Data naixement:</label>
                    <input type="date" class="form-control" id="naixement_empleat" placeholder="Entrar data empleat" name="naixement_empleat">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="nss_empleat" style="font-weight: bold">NSS:</label>
                    <input type="number" class="form-control" id="nss_empleat" placeholder="Entrar numero seguretat social empleat" name="nss_empleat">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="iban_empleat" style="font-weight: bold">IBAN:</label>
                    <input type="text" class="form-control" id="iban_empleat" placeholder="Entrar iban empleat" name="iban_empleat">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="actor" style="font-weight: bold">Actor:</label>
                    <input type="checkbox" class="form-control" id="actor_empleat" name="actor_empleat">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="director" style="font-weight: bold">Director:</label>
                    <input type="checkbox" class="form-control" id="director" name="director">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="tecnic_sala" style="font-weight: bold">Tecnic:</label>
                    <input type="checkbox" class="form-control" id="tecnic_sala" name="tecnic_sala">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="traductor" style="font-weight: bold">Traductor:</label>
                    <input type="checkbox" class="form-control" id="traductor" name="traductor_empleat">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="ajustador" style="font-weight: bold">Ajustador:</label>
                    <input type="checkbox" class="form-control" id="ajustador" name="ajustador">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="linguista" style="font-weight: bold">Linguista:</label>
                    <input type="checkbox" class="form-control" id="linguista" name="linguista">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_actor" style="font-weight: bold">Preu actor:</label>
                    <input type="number" class="form-control" id="preu_actor" placeholder="Entrar preu actor" name="preu_actor">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_director" style="font-weight: bold">Preu director:</label>
                    <input type="number" class="form-control" id="preu_director" placeholder="Entrar preu director" name="preu_director">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_tecnicSala" style="font-weight: bold">Preu tecnic de sala:</label>
                    <input type="number" class="form-control" id="preu_tecnicSala" placeholder="Entrar preu tecnic de Sala" name="preu_tecnicSala">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_traductor" style="font-weight: bold">Preu traductor:</label>
                    <input type="number" class="form-control" id="preu_traductor" placeholder="Entrar preu traductor" name="preu_traductor">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_ajustador" style="font-weight: bold">Preu ajustador:</label>
                    <input type="number" class="form-control" id="preu_ajustador" placeholder="Entrar preu ajustador" name="preu_ajustador">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="preu_linguista" style="font-weight: bold">Preu linguista:</label>
                    <input type="number" class="form-control" id="preu_linguista" placeholder="Entrar preu linguista" name="preu_linguista">
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($empleat) ? 'Guardar cambios' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
</div>

@endsection
