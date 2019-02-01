@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($usuario) ? 'Editar usuari' : 'Crear usuari'}}</h2>
    <form method = "POST" action="{{!empty($usuario) ? route('editarUsuariIntern', ['id' => $usuario->id_usuari]) : route('crearUsuariIntern')}}" onsubmit="return checkPass(this);" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="alias_usuari" style="font-weight: bold">Àlies:*</label>
                    <input type="text" class="form-control" id="alias_usuari" placeholder="Entrar àlies" required name="alias_usuari" value="{{!empty($usuario) ? $usuario->alias_usuari : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="email_usuari" style="font-weight: bold">Email:</label>
                    <input type="email" class="form-control" id="email_usuari" placeholder="Entrar correu" name="email_usuari" value="{{!empty($usuario) ? $usuario->email_usuari : ''}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="nom_usuari" style="font-weight: bold">Nom:</label>
                    <input type="text" class="form-control" id="nom_usuari" placeholder="Entrar nom" name="nom_usuari" value="{{!empty($usuario) ? $usuario->nom_usuari : ''}}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cognom1_usuari" style="font-weight: bold">Primer cognom:</label>
                    <input type="text" class="form-control" id="cognom1_usuari" placeholder="Entrar primer cognom" name="cognom1_usuari" value="{{!empty($usuario) ? $usuario->cognom1_usuari : ''}}">
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
                    <label for="cognom2_usuari" style="font-weight: bold">Segon cognom:</label>
                    <input type="text" class="form-control" id="cognom2_usuari" placeholder="Entrar segon cognom" name="cognom2_usuari" value="{{!empty($usuario) ? $usuario->cognom2_usuari : ''}}">
                </div>
            </div>

            <div class="col-6">
                <label for="cpass" style="font-weight: bold">Selecciona departament:</label>
                <select class="form-control" name="id_departament">
                @foreach( $departaments as $departament )
                    <option value="{{$departament['id_departament']}}" {{(!empty($usuario) && $usuario->id_departament == $departament['id_departament']) ? 'selected' : ''}} >{{$departament['nom_departament']}}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="contrasenya_usuari" style="font-weight: bold">{{empty($usuario) ? 'Nova contrasenya' : 'Contrasenya'}}:</label>
                    <input type="password" class="form-control" id="contrasenya_usuari" placeholder="Entrar contrasenya" name="contrasenya_usuari">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cpass" style="font-weight: bold">Confirma contrasenya:</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Confirmar contrasenya" name="cpass">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="imatge_usuari" style="font-weight: bold">Imatge Usuari:</label>
                <input type="file" name="imatge_usuari" />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($usuario) ? 'Guardar canvis' : 'Crear'}}</button>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    function checkPass(form){
        if(form.contrasenya_usuari.value == form.cpass.value) {
            return true;
        } else {
            alert('La contrasenya de confirmacio no es la mateix');
            return false;
        }
    }
</script>
@endsection
