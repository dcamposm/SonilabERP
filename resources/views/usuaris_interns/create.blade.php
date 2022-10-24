@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($usuario) ? 'EDITAR USUARI' : 'CREAR USUARI'}}</h2>
    <form method = "POST" action="{{!empty($usuario) ? route('editarUsuariIntern', ['id' => $usuario->id_usuari]) : route('crearUsuariIntern')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="alias_usuari" style="font-weight: bold">NOM:</label>
                    <input type="text" class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" id="alias_usuari" placeholder="Entrar àlies" name="alias_usuari" value="{{!empty($usuario) ? $usuario->alias_usuari : old('alias_usuari')}}" required>
                    <span class="text-danger">{{ $errors->first('alias_usuari') }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="email_usuari" style="font-weight: bold">EMAIL:</label>
                    <input type="email" class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" id="email_usuari" placeholder="Entrar correu" name="email_usuari" value="{{!empty($usuario) ? $usuario->email_usuari : old('email_usuari')}}">
                    <span class="text-danger">{{ $errors->first('email_usuari') }}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="cognom1_usuari" style="font-weight: bold">PRIMER COGNOM:</label>
                    <input type="text" class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" id="cognom1_usuari" placeholder="Entrar primer cognom" name="cognom1_usuari" value="{{!empty($usuario) ? $usuario->cognom1_usuari : old('cognom1_usuari')}}">
                    <span class="text-danger">{{ $errors->first('cognom1_usuari') }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cognom2_usuari" style="font-weight: bold">SEGON COGNOM:</label>
                    <input type="text" class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" id="cognom2_usuari" placeholder="Entrar segon cognom" name="cognom2_usuari" value="{{!empty($usuario) ? $usuario->cognom2_usuari : old('cognom2_usuari')}}">
                    <span class="text-danger">{{ $errors->first('cognom2_usuari') }}</span>
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
                <label for="cpass" style="font-weight: bold">DEPARTAMENT:</label>
                <select class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" name="id_departament">
                    <option></option>
                    @foreach( $departaments as $departament )
                        @if(Auth::user()->hasRole(['5']))
                            <option value="{{$departament['id_departament']}}" {{((!empty($usuario) && $usuario->id_departament == $departament['id_departament'])) || (old('id_departament') == $departament['id_departament']) ? 'selected' : ''}} >{{$departament['nom_departament']}}</option>
                        @else
                            @if($departament->id_departament != 5)
                                <option value="{{$departament['id_departament']}}" {{((!empty($usuario) && $usuario->id_departament == $departament['id_departament'])) || (old('id_departament') == $departament['id_departament']) ? 'selected' : ''}} >{{$departament['nom_departament']}}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
                <span class="text-danger">{{ $errors->first('id_departament') }}</span>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="telefon_usuario" style="font-weight: bold">TELEFON:</label>
                    <input type="tel" class="form-control {{!empty($usuario) ? 'is-valid' : ''}}" id="telefon_usuario" placeholder="Entrar segon cognom" name="telefon_usuario" value="{{!empty($usuario) ? $usuario->telefon_usuario : old('telefon_usuario')}}">
                    <span class="text-danger">{{ $errors->first('telefon_usuario') }}</span>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6">
                <div class="form-group">
                    <label for="contrasenya_usuari" style="font-weight: bold">{{empty($usuario) ? 'CONTRASENYA' : 'NOVA CONTRASENYA'}}:</label>
                    <input type="password" class="form-control" id="contrasenya_usuari" placeholder="Entrar contrasenya" name="contrasenya_usuari" value="{{old('contrasenya_usuari')}}">
                    <span class="text-danger">{{ $errors->first('contrasenya_usuari') }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="cpass" style="font-weight: bold">CONFIRMA CONTRASENYA:</label>
                    <input type="password" class="form-control" id="cpass" placeholder="Confirmar contrasenya" name="cpass">
                    <span class="text-danger">{{ $errors->first('cpass') }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3 ml-1">
            <div class="form-group">
                <label for="imatge_usuari" style="font-weight: bold">IMATGE USUARI:</label>
                <input type="file" name="imatge_usuari" />
            </div>
        </div>
        
        <div class="row justify-content-between">
            <a href="{{ url('/usuaris/index') }}" class="btn btn-primary col-2">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a> 
            <button type="submit" class="btn btn-success col-2">{{!empty($usuario) ? 'DESAR' : 'CREAR'}} <i class="fas fa-save"></i></i></button>     
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ URL::asset('js/custom/userCreate.js') }}"></script>
@endsection
