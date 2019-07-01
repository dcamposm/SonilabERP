@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div id="mySidenav" class="sidenav pt-5">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div id="trabajadores">

        </div>
    </div>

    <div id="contenedor" class="container-fluid contenedor mb-3">
        <div class="row encabezado mb-4">
            <div class="input-group">
                <input id="searchActor" class="form-control" style="width: 300px;"/>
                <input id="filtroActor" class="form-control" type="hidden" value="-1">
                <input id="searchEntrada" class="form-control" style="width: 300px;"/>
                <input id="filtroEntrada" class="form-control" type="hidden" value="-1">
                <div class="semana"><div id="semanaMenos" class="btn btn-primary round-left"><span class="fas fa-angle-double-left"></span></div><span class="simil-btn btn">{{$mes}}</span><div id="semanaMas" class="btn btn-primary round-right"><span class="fas fa-angle-double-right"></span></div></div>
                <button id="btnAdd" class="btn btn-success boton"  type="button" onclick="openNav()">AFEGIR</button>
             </div>
        </div>
        <div class="row" style="min-width: 2000px;">
            <div class="sala-vacia">
                <button type="button" class="btn btn-sm alternar">
                    <span class="fas fa-calendar" style="margin-right: 0px;"></span>
                </button>  
            </div>
            <div class="col col-fecha" style="font-weight: bold;">DILLUNS : {{$fechas[0]}}</div>
            <div class="col col-fecha" style="font-weight: bold;">DIMARTS : {{$fechas[1]}}</div>
            <div class="col col-fecha" style="font-weight: bold;">DIMECRES : {{$fechas[2]}}</div>
            <div class="col col-fecha" style="font-weight: bold;">DIJOUS : {{$fechas[3]}}</div>
            <div class="col col-fecha" style="font-weight: bold;">DIVENDRES : {{$fechas[4]}}</div>
        </div>
        <div id="calendarContent"></div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div style="flex-direction:column; width: 100%;">
                        <div style="width: 100%; float: left;">
                            <input type="hidden" id="">
                            <h5 class="modal-title" style="float: left;" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div style="clear:both"></div>
                        <h6 id="crear-subtitulo">Sub Title</h6>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="selectPelis"></label>
                            <input required id="selectPelis" class="form-control"/>
                            <input id="actorEstadillo" class="form-control" type="hidden" value="-1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="numberTakes" class="mt-3">Takes a realitzar:</label>
                            <input required id="numberTakes" class="form-control" type="number" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="takesIni">Hora d'inici:</label>
                            <input required id="takesIni" class="form-control" type="time">
                        </div>
                        <div class="form-group col">
                            <label for="takesFin">Hora final:</label>
                            <input required id="takesFin" class="form-control" type="time">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="canso">Canço</label>
                            <input id="canso" class="form-check-input ml-1" type="checkbox" value="1" readonly>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="narracio">Narració</label>
                            <input id="narracio" class="form-check-input ml-1" type="checkbox" value="1" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tancar</button>
                    <button id="btnGuardar" type="button" class="btn btn-success">Afegir</button>
                </div>
            </div>
        </div>
    </div>

    <div style="overflow: hidden;" class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div id="dialog" class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content" style="width: 100%; height: 900px;">
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
                        {{-- TODO: Modificar la función para guardar el técnico (front, back) para que admita los turnos. --}}
                        <table style="width: 50%;">
                            <thead>
                                <td></td>
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
                                        <form action="" method="POST">
                                            {{-- TODO: Falta pasarle el turno a la función. --}}
                                            <select id="tecnico0" class="form-control" name="tecnic" onchange="cambiarTecnico(0)">
                                                <option value="0" selected></option>
                                                @foreach($tecnics as $key => $tecnic)
                                                    {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                                                    <option value="{{$tecnic['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td><input type="color" class="form-control" name="color_empleat" id="color0" value="#ffffff" onchange="cambiarTecnico(0)"></td>
                                </tr>

                                <tr>
                                    <td>
                                        Torn tarda
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            {{-- TODO: Falta pasarle el turno a la función. --}}
                                            <select id="tecnico1" class="form-control" name="tecnic" onchange="cambiarTecnico(1)">
                                                <option value="0" selected></option>
                                                @foreach($tecnics as $key => $tecnic)
                                                    {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                                                    <option value="{{$tecnic['id_empleat']}}" {{--(algo) ? 'selected' : ''--}} >{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td><input type="color" class="form-control" name="color_empleat" id="color1" value="#ffffff" onchange="cambiarTecnico(1)"></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row">
                            <form id="pasarLista" action="" method="POST" class="col-8 mt-4">
                                <div style="background-color: whitesmoke; overflow-y: scroll; max-height: 294px;">
                                    <table class="table" style="width: 100%;  margin-top: 30px;">
                                        <tbody id="pasarLista-tabla">
                                            @foreach($actoresPorDia as $key => $dia)
                                                @foreach($dia as $key2 => $actor)
                                                    <tr id="{{$actor->id_calendar}}-{{$actor->id_actor_estadillo}}-{{$actor->num_sala}}" class="dia-{{$actor->dia}}-{{$actor->num_sala}} lista-actores">
                                                        <td id="actor_mod-{{ $actor->id_calendar }}" onclick="seleccionarActorCalendario(this.id, this)" class="col-8">
                                                            @if ($actor->id_director == 0)
                                                            <span class="horaActor">{{'('.$actor->hora.':'.$actor->minuts.')'}}</span> <span id="content_actor">{{$actor->nom_cognom}}</span>
                                                            @else
                                                                @foreach($directors as $director)
                                                                    @if ($actor->id_director == $director->id_empleat)
                                                                        <span class="horaActor">{{'('.$actor->hora.':'.$actor->minuts.')'}}</span> <span id="content_actor">{{$actor->nom_cognom}} - {{$director->nom_cognom}}</span>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                <label class="btn btn-success {{ $actor->asistencia == 1 ? 'active' : '' }}">
                                                                    <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="1" {{ $actor->asistencia == 1 ? 'checked' : '' }}> Present
                                                                </label>
                                                                <label class="btn btn-danger {{ $actor->asistencia === 0 ? 'active' : '' }}">
                                                                    <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="0" {{ $actor->asistencia === 0 ? 'checked' : '' }}> No present
                                                                </label>
                                                                <label class="btn btn-secondary {{ is_null($actor->asistencia) ? 'active' : '' }}">
                                                                    <input type="radio" name="actor-{{ $actor->id_empleat }}-{{$actor->id_calendar}}" id="actor-{{ $actor->id_empleat }}" class="actor-dia-{{$actor->dia}}-{{$actor->num_sala}}" autocomplete="off" value="null" {{ is_null($actor->asistencia) ? 'checked' : '' }}> Pendent
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
                                    <button id="enviarListaAsistencia" type="button" class="btn btn-success">Desar llista</button>
                                </div>
                            </form>

                            <div class="col-4 container">
                                <form action="" method="POST">
                                    <div>
                                        
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="selectPelis"></label>
                                                <input required id="selectPelis-editar" readonly class="form-control" style="width: 100%;"/>
                                                <input id="actorEstadillo-editar" class="form-control" type="hidden" value="-1">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="numberTakes-editar" class="mt-3">Takes a realitzar:</label>
                                                <input id="numberTakes-editar" class="form-control" type="number" min="1" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="takesIni-editar">Hora d'inici:</label>
                                                <input id="takesIni-editar" class="form-control" type="time" readonly>
                                            </div>
                                            <div class="form-group col">
                                                <label for="takesFin-editar">Hora final:</label>
                                                <input id="takesFin-editar" class="form-control" type="time" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-check form-check-inline">
                                                    <label class="form-check-label mt-3" for="canso-editar">Canço</label>
                                                    <input id="canso-editar" class="form-check-input ml-1 mt-3" type="checkbox" value="1" readonly>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label mt-3" for="narracio-editar">Narració</label>
                                                <input id="narracio-editar" class="form-check-input ml-1 mt-3" type="checkbox" value="1" readonly>
                                            </div>
                                            <div class="form-check col">
                                                <label for="selectDirector"></label>
                                                <input required id="selectDirector-editar" readonly class="form-control" style="width: 100%;" placeholder="Selecciona director"/>
                                                <input id="director-editar" class="form-control" type="hidden" value="-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <!-- TODO: Crear estas dos funciones en el fichero js -->
                                        <button class="btn btn-primary" id="botoEditar" type="button" onclick="editarActor()" disabled>Modificar</button>
                                        <button class="btn btn-danger" id="botoEliminarActor"  type="button" onclick="eliminarCalendarioActor()" disabled>Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
    var tecnicsAsignados = <?php echo json_encode($tecnicsAsignados) ?>;
    var rutaSearchEmpleat = "{{route('empleatSearch')}}";
    var rutaSearchEntrada = "{{route('registreEntradaSearch')}}";
    var rutaSearchProduccio = "{{route('registreProduccioSearch')}}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />

@stop
