@extends('layouts.app')

@section('content')

<div class="row">

    <div class="col-sm-4">
        <img src="{{$arrayUsuaris['imatge_usuari']}}">   

    </div>
    <div class="col-sm-8">
        <h1>Nom: {{ $arrayUsuaris['nom_usuari']}} {{ $arrayUsuaris['cognoms_usuari']}}</h1>
        <h3>email: {{$arrayUsuaris['email_usuari']}}</h3>
        <h3>Data de creació: {{$arrayUsuaris['created_at']}}</h3>
    </div>
</div>


@stop