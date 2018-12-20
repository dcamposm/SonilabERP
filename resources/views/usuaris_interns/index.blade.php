@extends('layouts.app')

@section('content')

<div class="row">

    @foreach( $arrayUsuaris as $key => $usuaris )
    <div class="col-xs-6 col-sm-4 col-md-3 text-center">

        <a href="{{ url('/catalog/show/' . $key ) }}" class="btn btn-outline-dark">
            <img src="{{$usuaris['imatge_usuari']}}" style="height:200px"/>
            <h4 style="min-height:45px;margin:5px 0 10px 0">
                {{$usuaris['nom_usuari']}} {{$usuaris['cognoms_usuari']}} 
            </h4>
        </a>

    </div>
    @endforeach

</div>

@stop