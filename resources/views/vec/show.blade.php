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
                <td class="col">{{ $vec->registreProduccio->id_registre_entrada }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">TITOL:</td>
                <td class="col">{{ $vec->registreProduccio->registreEntrada->titol }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">CLIENT:</td>
                <td class="col">{{ $vec->registreProduccio->registreEntrada->client->nom_client }}</td>
            </tr>
            @if ($vec->registreProduccio->subreferencia != 0)
            <tr class="row">
                <td class="font-weight-bold col-sm-3">EPISODI:</td>
                <td class="col">{{ $vec->registreProduccio->subreferencia }}</td>
            </tr>
            @endif
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ENTREGA:</td>
                <td class="col">{{ date('d/m/Y', strtotime($vec->registreProduccio->data_entrega)) }}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">DATA DE CREACIÓ:</td>
                <td class="col">{{ $vec['created_at']}}</td>
            </tr>
            <tr class="row">
                <td class="font-weight-bold col-sm-3">ÚLTIMA MODIFICACIÓ:</td>
                <td class="col">{{ $vec['updated_at']}}</td>
            </tr>
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
                    @foreach ($empleatsInfo['Actor'] as $actor)
                        <tr class="row">
                            <td class="col">{{$actor['nom']}}</td>
                            <td class="col">{{$actor['tk']}}</td>
                            <td class="col">{{$actor['cg']}}</td>
                            <td class="col">{{$actor['total']}}€</td>
                        </tr>
                    @endforeach
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
                        <th class="col-3">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleatsInfo as $key => $empleats)
                        @if ($key != 'Actor')
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
                    @endforeach
                    <tr class="row">
                        <td class="col-3"></td>
                        <td class="col font-weight-bold text-right">TOTAL COSTOS</td>
                        <td class="col-3">{{$total}}€</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <a href="{{ url('/vec') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
    </div>
</div>

@stop