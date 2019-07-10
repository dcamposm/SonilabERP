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
                    @if (Auth::user()->hasAnyRole(['1','5']))
                       @foreach ($user as $usuari)
                            @if (isset($usuari->missatgeDay))
                            @foreach($usuari->missatgeDay->where('type', 'registreEntradaCreate') as $missatge)
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
                            @endif
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('type', 'registreEntradaCreate') as $missatge)
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
                    @if (Auth::user()->hasAnyRole(['1','5']))
                       @foreach ($user as $usuari)
                            @if (isset($usuari->missatgeDay))
                                @foreach($usuari->missatgeDay->where('type', 'registreEntradaUpdate') as $missatge)
                                    <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}} - {{$usuari->alias_usuari}}</a></div>
                                @endforeach
                            @endif
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('type', 'registreEntradaUpdate') as $missatge)
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
                    @if (Auth::user()->hasAnyRole(['1','5']))
                       @foreach ($user as $usuari)
                            @if (isset($usuari->missatgeDay))
                                @foreach($usuari->missatgeDay->where('type', 'alertEntrega') as $missatge)
                                    @if ($missatge->referencia == 'registreEntrada'  && date("Y-m-d",strtotime(date("d-m-Y")."+ 7 days")) >= $missatge->data_final)
                                        <div class="alert alert-warning" role="alert">
                                            <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                                                @csrf
                                                <input type="hidden" id="searchBy" class="form-control" name="searchBy" value="id_registre_entrada">
                                                <input type="hidden" id="orderBy" class="form-control" name="orderBy" value="id_registre_entrada">
                                                <input type="hidden" id="search_term" class="form-control" name="search_term" value="{{$missatge->id_referencia}}">
                                                <a class="alert-link" onclick="this.parentNode.submit();" href="#">
                                                    {{$missatge->missatge}} - {{$usuari->alias_usuari}}
                                                </a>
                                            </form>
                                        </div>
                                    @elseif ($missatge->referencia == 'registreProduccio' && date("Y-m-d",strtotime(date("d-m-Y")."+ 7 days")) >= $missatge->data_final)
                                        <div class="alert alert-warning" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreProduccio', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                                    @endif
                                @endforeach
                            @endif
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('type', 'alertEntrega') as $missatge)
                            @if ($missatge->referencia == 'registreEntrada' && date("Y-m-d",strtotime(date("d-m-Y")."+ 7 days")) >= $missatge->data_final)
                                <div class="alert alert-warning" role="alert">
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
                            @elseif ($missatge->referencia == 'registreProduccio' && date("Y-m-d",strtotime(date("d-m-Y")."+ 7 days")) >= $missatge->data_final)
                                <div class="alert alert-warning" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreProduccio', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                            @endif
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
                    @if (Auth::user()->hasAnyRole(['1','5']))
                       @foreach ($user as $usuari)
                            @if (isset($usuari->missatgeDay))
                                @foreach($usuari->missatgeDay->where('type', 'alert') as $missatge)
                                    <div class="alert alert-success" role="alert"> <a class="alert-link" href="{{route('mostrarRegistreEntrada', array('id' => $missatge->id_referencia))}}">{{$missatge->missatge}}</a></div>
                                @endforeach
                            @endif
                       @endforeach
                    @else
                        @forelse($user->missatgeDay->where('type', 'alert') as $missatge)
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
                <div class="card-header">PLANNING DEL DÍA</div>

                <div class="card-body">
                    *CALENDARI
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/custom/home.js') }}"></script>
@endsection
