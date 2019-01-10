@extends('layouts.app')

@section('content')

<div>
    <a href="{{ url('/empleats/crear') }}" class="btn btn-success">
        <span class="fas fa-user-plus"></span>
        Afegir treballador
    </a>
</div>

<div class="row">

    @foreach( $empleats as $key => $empleat )

    <div class="card card-shadow col-xs-6 col-sm-4 col-md-3 text-center m-3" style="min-width: 200px;">

        <div class="card-body" href="{{ url('/usuaris/interns/show/' . $key ) }}" >
            <img src="{{url('/')}}/img/usuaris/{{$empleat['imatge_empleat']}}" class="rounded-circle" style="height:150px"/>
            
            <h4 style="min-height:45px;margin:5px 0 10px 0">
                <a href="{{ route('empleatShow', ['id' => $empleat['id_empleat']]) }}" style="text-decoration:none; color:black; font-size: 1.35rem;">
                    {{$empleat['nom_empleat']}} {{$empleat['cognoms_empleat']}} 
                </a>
            </h4>
            <div class="row">
                <div class="col-6" style="padding: 0px;">
                    <a href="{{ route('empleatUpdateView', ['id' => $empleat['id_empleat']]) }}" class="btn btn-outline-primary w-100"> Editar </a> 
                </div>
                <div class="col-6" style="padding: 0px;">
                    <form action="{{ route('empleatDelete') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{$empleat['id_empleat']}}">
                        <button class="btn btn-outline-danger">Esborrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endforeach

</div>


@stop