@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($registreProduccio) ? 'Editar registre de producció' : 'Crear registre de producció'}}</h2>
    <form method = "POST" action="#" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                
                <div class="col-6">
                    <label for="registre Entrada" style="font-weight: bold">Selecciona registre d'entrada:</label>
                    <select class="form-control" name="id_registreEntrada">
                        @foreach( $registresEntrada as $registreEntrada )
                        <option value="{{$registreEntrada['id_registre_entrada']}}" {{(!empty($registreEntrada)) ? 'selected' : ''}} >{{$registreEntrada['titol']}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="entrada" style="font-weight: bold">Data Entrada:</label>
                        <input type="date" class="form-control" id="entrada" placeholder="Entrar data Entrada" name="entrada" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->entrada)[0] : ''}}">
                    </div>
                </div>
            </div>

        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($registreProduccio) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
</div>


@endsection
