@extends('layouts.app')

@section('content')

<div>
    <a href="{{ url('/usuaris/interns/crear') }}" class="btn btn-success">
        <span class="fas fa-user-plus"></span>
        Crear nou usuari
    </a>
</div>

<div class="row">

    @foreach( $arrayUsuaris as $key => $usuaris )
    <div class="card card-shadow col-xs-6 col-sm-4 col-md-3 text-center m-3">

        <div class="card-body" href="{{ url('/usuaris/interns/show/' . $key ) }}" >
            <img src="{{$usuaris['imatge_usuari']}}" style="height:200px"/>
            <h4 style="min-height:45px;margin:5px 0 10px 0">
                {{$usuaris['nom_usuari']}} {{$usuaris['cognoms_usuari']}} 
            </h4>
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('editarUsuariIntern', ['id' => $usuaris['id_usuari']]) }}" class="btn btn-outline-primary w-100"> Editar </a> 
                </div>
                <div class="col-6">
                    <form action="{{ route('esborrarUsuariIntern') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{$usuaris['id_usuari']}}">
                        <button class="btn btn-outline-danger w-100">Esborrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach

</div>


@stop