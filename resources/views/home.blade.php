@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ÚLTIMS REGISTRES CREATS</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::user()->hasRole('4'))
                       @foreach ($user as $usuari)
                            @foreach($usuari->missatgeDay->where('referencia', 'registreEntradaCreate') as $missatge)
                                <div class="alert alert-success" role="alert">
                                    <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                                        @csrf
                                        <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="id_registre_entrada">
                                        <input type="hidden" id="searchBy" class="form-control" name="orderBy" value="id_registre_entrada">
                                        <input type="hidden" id="search_term" class="form-control" name="search_term" value="{{$missatge->id_referencia}}">
                                        <a class="alert-link" onclick="this.parentNode.submit();" href="#">
                                            {{$missatge->missatge}} - {{$usuari->alias_usuari}}
                                        </a>
                                    </form>
                                </div>
                            @endforeach
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('referencia', 'registreEntradaCreate') as $missatge)
                            <div class="alert alert-success" role="alert">
                                <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                                    @csrf
                                    <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="id_registre_entrada">
                                    <input type="hidden" id="searchBy" class="form-control" name="orderBy" value="id_registre_entrada">
                                    <input type="hidden" id="search_term" class="form-control" name="search_term" value="{{$missatge->id_referencia}}">
                                    <a class="alert-link" onclick="this.parentNode.submit();" href="#">
                                        {{$missatge->missatge}}
                                    </a>
                                </form>

                            </div>
                        @empty
                            No tens missatges.
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ÚLTIMS REGISTRES MODIFICATS</div>

                <div class="card-body">
                    @if (Auth::user()->hasRole('4'))
                       @foreach ($user as $usuari)
                            @foreach($usuari->missatgeDay->where('referencia', 'registreEntradaUpdate') as $missatge)
                                <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                            @endforeach
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('referencia', 'registreEntradaUpdate') as $missatge)
                            <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                        @empty
                            No tens missatges.
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-header">AVISOS D'ENTREGUES</div>

                <div class="card-body">
                    @if (Auth::user()->hasRole('4'))
                       @foreach ($user as $usuari)
                            @foreach($usuari->missatgeDay->where('referencia', 'avisosEntrega') as $missatge)
                                <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                            @endforeach
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('referencia', 'avisosEntrega') as $missatge)
                            <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                        @empty
                            No tens missatges.
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-header">ALERTES</div>

                <div class="card-body">
                    @if (Auth::user()->hasRole('4'))
                       @foreach ($user as $usuari)
                            @foreach($usuari->missatgeDay->where('referencia', 'alert') as $missatge)
                                <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                            @endforeach
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('referencia', 'alert') as $missatge)
                            <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                        @empty
                            No tens missatges.
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">HORARIS DEL DÍA</div>

                <div class="card-body">
                    *CALENDARI
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
