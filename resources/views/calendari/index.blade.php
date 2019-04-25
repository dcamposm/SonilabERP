@extends('layouts.app')

@section('content')

<div id="contenedor" class="container-fluid contenedor">
    <div class="row">
        <div style="width: 100%; text-align: center;"><-- Semana {{$numSemana}} --></div>
    </div>
    <div class="row">
        <div style="padding:15px"></div>
        <div class="col col-fecha">Lunes : {{$fechas[0]}}</div>
        <div class="col col-fecha">Martes : {{$fechas[1]}}</div>
        <div class="col col-fecha">Miércoles : {{$fechas[2]}}</div>
        <div class="col col-fecha">Jueves : {{$fechas[3]}}</div>
        <div class="col col-fecha">Viernes : {{$fechas[4]}}</div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />

@stop
