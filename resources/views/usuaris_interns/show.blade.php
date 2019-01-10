@extends('layouts.app')

@section('content')

<div class="row">

    <div class="col-sm-4">
        <img src="{{url('/')}}/img/usuaris/{{$arrayUsuaris['imatge_usuari']}}" class="rounded" style="height:150px"/>
    </div>
    <div class="col-sm-8">
        <h1>Nom: {{ $arrayUsuaris['nom_usuari']}} {{ $arrayUsuaris['cognoms_usuari']}}</h1>
        <h3>email: {{$arrayUsuaris['email_usuari']}}</h3>
        <h3>Data de creació: {{$arrayUsuaris['created_at']}}</h3>
    </div>
</div>


@stop