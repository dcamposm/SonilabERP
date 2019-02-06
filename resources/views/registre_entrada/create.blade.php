@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($registreEntrada) ? 'Editar registre Entrada' : 'Crear registre Entrada'}}</h2>
    <form method = "POST" action="{{ route('registreEntradaInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="titol" style="font-weight: bold">Titol:</label>
                        <input type="text" class="form-control" id="nom_titol" placeholder="Entrar titol" name="titol" value="{{!empty($registreEntrada) ? $registreEntrada->titol : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="entrada" style="font-weight: bold">Data Entrada:</label>
                        <input type="date" class="form-control" id="entrada" placeholder="Entrar data Entrada" name="entrada" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->entrada)[0] : ''}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="sortida" style="font-weight: bold">Data Sortida:</label>
                        <input type="date" class="form-control" id="sortida" placeholder="Entrar data Sortida" name="sortida" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->sortida)[0] : ''}}">
                    </div>
                </div>

                <div class="col-6">
                    <label for="client" style="font-weight: bold">Selecciona client existent:</label>
                    <select class="form-control" name="id_client">
                        @foreach( $clients as $client )
                        <option value="{{$client['id_client']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $client['id_client']) ? 'selected' : ''}} >{{$client['nom_client']}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <label for="client" style="font-weight: bold">Selecciona servei:</label>
                    <select class="form-control" name="id_servei">
                        @foreach( $serveis as $servei )
                        <option value="{{$servei['id_servei']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $client['id_servei']) ? 'selected' : ''}} >{{$servei['nom_servei']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="idioma" style="font-weight: bold">Selecciona idioma:</label>
                    <select class="form-control" name="id_idioma">
                        @foreach( $idiomes as $idioma )
                        <option value="{{$idioma['id_idioma']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $idioma['id_idioma']) ? 'selected' : ''}} >{{$idioma['idioma']}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <label for="media" style="font-weight: bold">Selecciona tipus:</label>
                    <select class="form-control" name="id_media">
                        @foreach( $medias as $media )
                        <option value="{{$media['id_media']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $media['id_media']) ? 'selected' : ''}} >{{$media['nom_media']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="minuts" style="font-weight: bold">Minuts:</label>
                        <input type="number" class="form-control" id="minuts" name="minuts" value="{{!empty($registreEntrada) ? $registreEntrada->minuts : ''}}">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="total_episodis" style="font-weight: bold">Episodis totals:</label>
                        <input type="number" class="form-control" id="total_episodis" name="total_episodis" value="{{!empty($registreEntrada) ? $registreEntrada->total_episodis : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="episodis_setmanals" style="font-weight: bold">Episodis setmanals:</label>
                        <input type="number" class="form-control" id="episodis_setmanals" name="episodis_setmanals" value="{{!empty($registreEntrada) ? $registreEntrada->episodis_setmanals : ''}}">                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="entregues_setmanals" style="font-weight: bold">Entregues setmanals:</label>
                        <input type="number" class="form-control" id="entregues_setmanals" name="entregues_setmanals" value="{{!empty($registreEntrada) ? $registreEntrada->entregues_setmanals : ''}}">
                    </div>
                </div>
                <div class="col-6">
                        <label for="episodis_setmanals" style="font-weight: bold">Estat:</label>
                        <select class="form-control" name="estat">
                            <option value="Pendent" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Pendent') ? 'selected' : ''}}>Pendent</option>
                            <option value="Finalitzada" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Finalitzada') ? 'selected' : ''}}>Finalitzada</option>
                            <option value="Cancel·lada" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Cancel·lada') ? 'selected' : ''}}>Cancel·lada</option>
                        </select>
                </div>

        </fieldset>


        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($registreEntrada) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
</div>


@endsection
