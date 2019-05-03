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
        <div class="col col-fecha">Dilluns : {{$fechas[0]}}</div>
        <div class="col col-fecha">Dimarts : {{$fechas[1]}}</div>
        <div class="col col-fecha">Dimecres : {{$fechas[2]}}</div>
        <div class="col col-fecha">Dijous : {{$fechas[3]}}</div>
        <div class="col col-fecha">Divendres : {{$fechas[4]}}</div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <input type="hidden" id="">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="takes-celda"></p>
            <label for="selectPelis"></label>
            <select id="selectPelis"></select><br/><br/>
            <label for="numberTakes">Takes a realizar:</label>
            <input id="numberTakes" type="number" min="1"><br/><br/>
            <label for="takesIni">Hora de inicio:</label>
            <input id="takesIni" type="time">
            <label for="takesFin">Hora final:</label>
            <input id="takesFin" type="time">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="btnGuardar" type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

<div style="overflow: hidden;" class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="dialog" class="modal-dialog" role="document">
        <div class="modal-content" style="width: 100%; height: 100%;">
            <div class="modal-header">
                <input type="hidden" id="">
                <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>

                <span style="margin-left: 20px;">Director: </span>
                {{-- TODO: Falta especificar la acción correspondiente. --}}
                <form action="/pepe" method="POST" style="margin-left: 5px;">
                    <select name="director" onchange="this.form.submit()">
                        @foreach($directors as $key => $director)
                            {{-- TODO: Falta hacer la condición para seleccionar el director seleccionado. --}}
                            <option value="{{$director['nom_empleat']}} {{ $director['cognom1_empleat'] }} {{ $director['cognom2_empleat'] }}" {{--(algo) ? 'selected' : ''--}} >{{$director['nom_empleat']}} {{ $director['cognom1_empleat'] }} {{ $director['cognom2_empleat'] }}</option>
                        @endforeach
                    </select>
                </form>

                <span style="margin-left: 20px;">Tècnic: </span>
                {{-- TODO: Falta especificar la acción correspondiente. --}}
                <form action="/pepe" method="POST" style="margin-left: 5px;">
                    <select name="tecnic" onchange="this.form.submit()">
                        @foreach($tecnics as $key => $tecnic)
                            {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                            <option value="{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}" {{--(algo) ? 'selected' : ''--}} >{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                        @endforeach
                    </select>
                </form>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="tablaHoras" class="">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var week = {{$week}}
    var year = {{$year}}
    var dias = <?php echo json_encode($fechas) ?>;
    var urlBase = "<?php echo $urlBase ?>"
    var data = <?php echo $data ?>;
    
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />

@stop