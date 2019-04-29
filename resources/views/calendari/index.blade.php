@extends('layouts.app')

@section('content')

<div id="mySidenav" class="sidenav pt-5">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div id="trabajadores">

    </div>
</div>

<div id="contenedor" class="container-fluid contenedor">
    <div class="row encabezado">
        <div class="semana"><div id="semanaMenos" class="btn btn-primary round-left"><span class="fas fa-angle-double-left"></span></div><span class="simil-btn btn">Semana {{$week}}</span><div id="semanaMas" class="btn btn-primary round-right"><span class="fas fa-angle-double-right"></span></div></div>
        <button id="btnAdd" class="btn btn-outline-primary boton" onclick="openNav()">Afegir</button>
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

<script>
    var week = {{$week}}
    var year = {{$year}}
    var urlBase = "<?php echo $urlBase ?>"

    
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />

@stop
