@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">Crear usuario</h2>
    <form>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="nom" style="font-weight: bold">Nom:</label>
                    <input type="text" class="form-control" id="nom" placeholder="Entrar nom" name="nom">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cognoms" style="font-weight: bold">Cognoms:</label>
                    <input type="text" class="form-control" id="cognoms" placeholder="Entrar cognoms" name="cognoms">
                </div>
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="email" style="font-weight: bold">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Entrar correu" name="correu">
                </div> 
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="alias" style="font-weight: bold">Alias:</label>
                    <input type="text" class="form-control" id="alias" placeholder="Entrar alias" name="alias">
                </div>
            </div>
            <!--<div class="col-6">
                <div class="form-group">
                    <label for="telefon" style="font-weight: bold">Telefon:</label>
                    <input type="tel" class="form-control" id="telefon" placeholder="Entrar telefon" name="telefon">
                </div>
            </div>-->
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="pass" style="font-weight: bold">Contrassenya:</label>
                    <input type="password" class="form-control" id="pass" placeholder="Entrar contrassenya" name="pass">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cpass" style="font-weight: bold">Confirma contrassenya:</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Confirmar contrassenya" name="cpass">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
            
                <label for="cpass" style="font-weight: bold">Selecciona departament:</label>
                <select class="form-control">
                @foreach( $departaments as $departament )
                    <option value="{{$departament['id_departament']}}">{{$departament['nom_departament']}}</option>
                @endforeach
                </select>
            
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <button type="submit" class="btn btn-success col-4">Crear</button>
            </div>
        </div>

    </form>
</div>

@endsection
