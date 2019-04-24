@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr class="row">
                <th class="col">VALORACIÓ ECONÒMICA</th>
            </tr>
        </thead>

        <tbody>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">REFÈRENCIA:</td>
                <td class="col">{{ isset($vec->registreProduccio->id_registre_entrada) ? $vec->registreProduccio->id_registre_entrada : $vec['ref'] }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">TITOL:</td>
                <td class="col">{{ isset($vec->registreProduccio->registreEntrada->titol) ? $vec->registreProduccio->registreEntrada->titol : $vec['titol'] }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">CLIENT:</td>
                <td class="col">{{ isset($vec->registreProduccio->registreEntrada->client->nom_client) ? $vec->registreProduccio->registreEntrada->client->nom_client : $vec['client'] }}</td>
            </tr>
            @if (isset($vec->registreProduccio->subreferencia))
                @if ($vec->registreProduccio->subreferencia != 0)
                <tr class="row">
                    <td class="font-weight-bold col-sm-3">EPISODI:</td>
                    <td class="col">{{ $vec->registreProduccio->subreferencia }}</td>
                </tr>
                @endif
            @else
                <tr class="row">
                    <td class="font-weight-bold col-sm-3">EPISODIS:</td>
                    <td class="col">
                        @foreach($vec['episodis'] as $cont => $episodi)
                            @if ($cont != '0')
                                {{ ", ".$episodi }}
                            @else
                                {{ $episodi }}
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endif
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ENTREGA:</td>
                <td class="col">{{isset($vec->registreProduccio->data_entrega) ? date('d/m/Y', strtotime($vec->registreProduccio->data_entrega)) : $vec['entrega'] }}</td>
            </tr>
            @if (isset($vec['created_at']))
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DATA DE CREACIÓ:</td>
                <td class="col">{{ $vec['created_at']}}</td>
            </tr>
            @endif
            @if (isset($vec['updated_at']))
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÚLTIMA MODIFICACIÓ:</td>
                <td class="col">{{ $vec['updated_at']}}</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead class="thead-dark" style="border-left: 3px solid white">
                    <tr class="row">
                        <th class="col">ACTORS</th>
                        <th class="col">TK's</th>
                        <th class="col">CG's</th>
                        <th class="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($empleatsInfo['Actor']))
                    @foreach ($empleatsInfo['Actor'] as $actor)
                        <tr class="row">
                            <td class="col">{{$actor['nom']}}</td>
                            <td class="col">{{$actor['tk']}}</td>
                            <td class="col">{{$actor['cg']}}</td>
                            <td class="col">{{$actor['total']}}€</td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead class="thead-dark" style="border-left: 3px solid white">
                    <tr class="row">
                        <th class="col-3">COL·LABORADORS</th>
                        <th class="col">TASCA</th>
                        @if (!isset($vec->registreProduccio->subreferencia))
                            <th class="col">EPISODIS</th>
                        @endif
                        <th class="col-3">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleatsInfo as $key => $empleats)
                        @if ($key != 'Actor')
                        @if (!isset($vec->registreProduccio->subreferencia))
                            @foreach ($empleats as $empleat)
                                @foreach ($empleat['tasca'] as $key2 => $tasca)
                                    <tr class="row">
                                        <td class="col-3">{{$empleat['nom']}}</td>
                                        <td class="col"> {{mb_strtoupper($key2)}}</td>
                                        <td class="col">
                                            @foreach ($tasca['episodis'] as $key3 => $episodi)
                                                @if ($key3 != '0')
                                                    {{ ", ".$episodi }}
                                                @else
                                                    {{ $episodi }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="col-3">{{$tasca['cost']}}€</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            @foreach ($empleats as $empleat)
                                <tr class="row">
                                    <td class="col-3">{{$empleat['nom']}}</td>
                                    
                                    <td class="col">
                                        @foreach ($empleat['tasca'] as $key2 => $tasca)
                                            @if ($key2 != '0')
                                                {{ ", ".mb_strtoupper($tasca) }}
                                            @else
                                                {{ mb_strtoupper($tasca) }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="col-3">{{$empleat['total']}}€</td>
                                </tr>
                            @endforeach
                        @endif
                        @endif
                    @endforeach
                    @if (isset($totalSS))
                    <tr class="row text-white" style="background-color: #212529;">
                        <td class="col">SEGURETAT SOCIAL</td>
                        <td class="col-3">{{number_format($totalSS, 2, '.', '')}}€</td>
                    </tr>
                    @endif
                    <tr class="row text-white" style="background-color: #212529;">
                        <td class="col font-weight-bold text-right">TOTAL COSTOS</td>
                        <td class="col-3">{{number_format($total, 2, '.', '')}}€</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div>
        <a href="{{ !isset($return) ? url('/vec') : url()->previous() }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
    </div>
</div>

@stop
