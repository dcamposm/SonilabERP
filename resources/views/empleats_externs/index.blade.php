@extends('layouts.app')

@section('content')

<div>
    <a href="{{ url('/empleats/crear') }}" class="btn btn-success">
        <span class="fas fa-user-plus"></span>
        Crear nou empleat
    </a>
</div>

<div class="row">

    @foreach( $empleats as $key => $empleat )

    {{--TODO: Hacer index--}}
    
    @endforeach

</div>


@stop