@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Últims missatges</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (!empty($user->missatgeDay[0]))
                        @foreach($user->missatgeDay as $missatge)
                            @if ($missatge->referencia == 'registreEntrada')
                                <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                            @endif
                        @endforeach
                    @else
                        No tens missatges.
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
