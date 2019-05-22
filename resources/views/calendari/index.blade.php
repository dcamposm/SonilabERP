@extends('layouts.app')

@section('content')

<div id="mySidenav" class="sidenav pt-5">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div id="trabajadores">

    </div>
</div>

<div id="contenedor" class="container-fluid contenedor">
    <div class="row encabezado">
        <div class="input-group">
            <select class="custom-select" id='filtroActor'>
                <option selected value="-1">Filtrar per actor</option>
                @foreach ($todosActores as $item)
                    <option value="{{$item->id_empleat}}">{{$item->nom_empleat}} {{$item->cognom1_empleat}} {{$item->cognom2_empleat}}</option>
                @endforeach
            </select>
            <select class="custom-select" id='filtroProyecto'>
                <option selected value="-1">Filtrar per proyecte</option>
                @foreach ($registrosEntrada as $item)
                    <option value="{{$item->id_registre_entrada}}">{{$item->titol}}</option>
                @endforeach
            </select>
            <div class="semana"><div id="semanaMenos" class="btn btn-primary round-left"><span class="fas fa-angle-double-left"></span></div><span class="simil-btn btn">Semana {{$week}}</span><div id="semanaMas" class="btn btn-primary round-right"><span class="fas fa-angle-double-right"></span></div></div>
            <button id="btnAdd" class="btn btn-outline-primary boton" onclick="openNav()">Afegir</button>
         </div>
    </div>
    <div class="row">
        <div style="padding:15px"></div>
        <div class="col col-fecha">Dilluns : {{$fechas[0]}}</div>
        <div class="col col-fecha">Dimarts : {{$fechas[1]}}</div>
        <div class="col col-fecha">Dimecres : {{$fechas[2]}}</div>
        <div class="col col-fecha">Dijous : {{$fechas[3]}}</div>
        <div class="col col-fecha">Divendres : {{$fechas[4]}}</div>
    </div>
    <div id="calendarContent"></div>
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
            <div class="modal-header" style="display: flex; align-items: center;">
                <input type="hidden" id="">
                <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="tablaHoras" class="">
                    
                </div>
                <div style="margin-top: 30px;">
                    {{-- TODO: Modificar la función para guardar el director y el técnico (front, back) para que admita los turnos. --}}
                    <table style="width: 50%;">
                        <thead>
                            <td></td>
                            <td>
                                Director
                            </td>
                            <td>
                                Técnic
                            </td>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Torn matí
                                </td>
                                <td>
                                    <form action="" method="POST" style="margin-left: 5px;">
                                        {{-- TODO: Falta pasarle el turno a la función. --}}
                                        <select id="director0" class="form-control" name="director" onchange="cambiarDirector(0)">
                                            <option value="" selected="true" disabled="disabled">Sel·leccioni director</option>
                                            @foreach($directors as $key => $director)
                                                {{-- TODO: Falta hacer la condición para seleccionar el director seleccionado. --}}
                                                <option value="{{$director['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$director['nom_empleat']}} {{ $director['cognom1_empleat'] }} {{ $director['cognom2_empleat'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="POST" style="margin-left: 5px;">
                                        {{-- TODO: Falta pasarle el turno a la función. --}}
                                        <select id="tecnico0" class="form-control" name="tecnic" onchange="cambiarTecnico(0)">
                                            <option value="" selected="true" disabled="disabled">Sel·leccioni tècnic</option>
                                            @foreach($tecnics as $key => $tecnic)
                                                {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                                                <option value="{{$tecnic['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Torn tarda
                                </td>
                                <td>
                                    <form action="" method="POST" style="margin-left: 5px;">
                                        {{-- TODO: Falta pasarle el turno a la función. --}}
                                        <select id="director1" class="form-control" name="director" onchange="cambiarDirector(1)">
                                            <option value="" selected="true" disabled="disabled">Sel·leccioni director</option>
                                            @foreach($directors as $key => $director)
                                                {{-- TODO: Falta hacer la condición para seleccionar el director seleccionado. --}}
                                                <option value="{{$director['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$director['nom_empleat']}} {{ $director['cognom1_empleat'] }} {{ $director['cognom2_empleat'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="POST" style="margin-left: 5px;">
                                        {{-- TODO: Falta pasarle el turno a la función. --}}
                                        <select id="tecnico1" class="form-control" name="tecnic" onchange="cambiarTecnico(1)">
                                            <option value="" selected="true" disabled="disabled">Sel·leccioni tècnic</option>
                                            @foreach($tecnics as $key => $tecnic)
                                                {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                                                <option value="{{$tecnic['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <form  id="pasarLista" action="" method="POST" style="margin-top: 15px;">
                        <div style="background-color: whitesmoke; height: 250px; width: 50%; overflow-y: scroll;">
                            <table class="table" style="width: 100%; margin-top: 30px;">
                                <tbody>
                                    @foreach($actoresPorDia as $key => $dia)
                                        @foreach($dia as $key2 => $actor)
                                            <tr class="dia-{{$actor->dia}}-{{$actor->num_sala}} lista-actores">
                                                <td>
                                                    {{'('.$actor->hora.':'.$actor->minuts.')'}} {{$actor->nom_empleat}} {{$actor->cognom1_empleat}} {{$actor->cognom2_empleat}}
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-success">
                                                            <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="1"> Present
                                                        </label>
                                                        <label class="btn btn-danger">
                                                            <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="0"> No present
                                                        </label>
                                                        <label class="btn btn-secondary active">
                                                            <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="null" checked> Pendent
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 15px;">
                            <button id="enviarListaAsistencia" class="btn btn-success">Desar llista</button>
                        </div>
                    </form>
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
    var actores = <?php echo $actores ?>;
    var dataBase = data;   
    var directoresAsignados = <?php echo json_encode($directoresAsignados) ?>;
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />

@stop
