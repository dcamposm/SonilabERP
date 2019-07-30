@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div id="mySidenav" class="sidenav pt-5">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <input id="searchActorSide" class="form-control"/>
        <div id="trabajadores">

        </div>
    </div>

    <div id="contenedor" class="container-fluid contenedor mb-3">
        <div class="row encabezado mb-4 justify-content-between">
            <div class="col">
                <div class="input-group">
                    <input id="searchActor" class="form-control" style="width: 300px;"/>
                    <input id="searchEntrada" class="form-control" style="width: 300px;"/>
                 </div>
            </div>
            <div class="col">
                <div class="semana"><div id="semanaMenos" class="btn btn-primary round-left"><span class="fas fa-angle-double-left"></span></div><span class="simil-btn btn">{{$mes}}</span><div id="semanaMas" class="btn btn-primary round-right"><span class="fas fa-angle-double-right"></span></div></div>
            </div>
            <button id="download-pdf" class="btn btn-primary boton"><i class="fas fa-print"></i>IMPRIMIR</button>
            <button id="btnAdd" class="btn btn-primary boton" data-toggle="modal" data-target="#modalConf">CONFIGURAR</button>
            <button id="btnAdd" class="btn btn-success boton" type="button" onclick="openNav()">AFEGIR</button>
        </div>
        <div id="calendar" style="min-width: 2500px; padding-left: 15px; padding-right: 15px;">
            <div class="row" id="headerCotent" style="min-width: 2500px;">
                <div class="sala-vacia">
                    <button type="button" class="btn btn-sm alternar">
                        <span class="fas fa-calendar" style="margin-right: 0px;"></span>
                    </button>  
                </div>
                <div class="col col-fecha cursor" id="day" onclick="showDay('{{date('d-m-Y', strtotime($fechas[0]))}}')" dia="{{date('d/m/Y', strtotime($fechas[0]))}}" style="font-weight: bold;">DILLUNS : {{date('d/m/Y', strtotime($fechas[0]))}}</div>
                <div class="col col-fecha cursor" id="day" onclick="showDay('{{date('d-m-Y', strtotime($fechas[1]))}}')" dia="{{date('d/m/Y', strtotime($fechas[1]))}}" style="font-weight: bold;">DIMARTS : {{date('d/m/Y', strtotime($fechas[1]))}}</div>
                <div class="col col-fecha cursor" id="day" onclick="showDay('{{date('d-m-Y', strtotime($fechas[2]))}}')" dia="{{date('d/m/Y', strtotime($fechas[2]))}}" style="font-weight: bold;">DIMECRES : {{date('d/m/Y', strtotime($fechas[2]))}}</div>
                <div class="col col-fecha cursor" id="day" onclick="showDay('{{date('d-m-Y', strtotime($fechas[3]))}}')" dia="{{date('d/m/Y', strtotime($fechas[3]))}}" style="font-weight: bold;">DIJOUS : {{date('d/m/Y', strtotime($fechas[3]))}}</div>
                <div class="col col-fecha cursor" id="day" onclick="showDay('{{date('d-m-Y', strtotime($fechas[4]))}}')" dia="{{date('d/m/Y', strtotime($fechas[4]))}}" style="font-weight: bold;">DIVENDRES : {{date('d/m/Y', strtotime($fechas[4]))}}</div>
            </div>
            <div id="calendarContent"></div>
        </div>
        
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
                <div class="modal-body" id="formAfegir">
                    <div class="alert alert-danger" id="errorAfegir" role="alert" hidden>
                        <span class="fas fa-exclamation-circle"></span> ERROR
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="selectPelis"></label>
                            <input required id="selectPelis" class="form-control"/>
                            <input id="actor" class="form-control" type="hidden" value="-1">
                            <input id="registreEntrada" class="form-control" type="hidden" value="-1">
                            <input id="setmana" class="form-control" type="hidden" value="-1">
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
                            <input required id="takesIni" class="form-control" min="8:30" type="time">
                        </div>
                        <div class="form-group col">
                            <label for="opcio_calendar">Opcions:</label>
                            <select id="opcio_calendar" class="form-control" name="opcio_calendar">
                                <option></option>
                                <option value="0">TAKES</option>
                                <option value="canço">CANÇO</option>
                                <option value="narrador">NARRADOR</option>
                                <option value="retakes">RETAKES</option>
                                <option value="cues">CUES</option>
                                <option value="casting">CASTING</option>
                                <option value="trailer">TRAILER</option>
                            </select>
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
                    <div style="margin-top: 30px;">
                        {{-- TODO: Modificar la función para guardar el técnico (front, back) para que admita los turnos. --}}
                        <table style="width: 50%;" class="mb-4">
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
                                                    <option value="{{$tecnic['id_empleat']}}">{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
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
                                        <form action="" method="POST">
                                            {{-- TODO: Falta pasarle el turno a la función. --}}
                                            <select id="tecnico1" class="form-control" name="tecnic" onchange="cambiarTecnico(1)">
                                                <option value="0" selected></option>
                                                @foreach($tecnics as $key => $tecnic)
                                                    {{-- TODO: Falta hacer la condición para seleccionar el técnico seleccionado. --}}
                                                    <option value="{{$tecnic['id_empleat']}}">{{$tecnic['nom_empleat']}} {{ $tecnic['cognom1_empleat'] }} {{ $tecnic['cognom2_empleat'] }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row justify-content-between">
                            <div>
                                <button class="btn btn-success btn-sm ml-3 mb-2" type="button" onclick="menuAfegir()">AFEGIR ACTOR</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div style="background-color: whitesmoke; overflow-y: scroll; height: 200px; width: 100%;">
                                        <table class="table" style="width: 100%;  margin-top: 30px;">
                                            <thead>
                                                <tr>
                                                    <th>MATÍ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pasarListaMati-tabla">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="background-color: whitesmoke; overflow-y: scroll; height: 200px;  width: 100%;">
                                        <table class="table" style="width: 100%;  margin-top: 30px;">
                                            <thead>
                                                <tr>
                                                    <th>TARDA</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pasarListaTarda-tabla">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-4 container" id="menuActors" hidden>
                                <div class="alert alert-danger" id="errorEditar" role="alert" hidden>
                                    <span class="fas fa-exclamation-circle"></span> ERROR
                                </div>
                                <form action="" method="POST" id="formEditar">
                                    <div>
                                        <div class="form-row" id="formSelectActor" hidden>
                                            <div class="col">
                                                <label for="selectActor"></label>
                                                <input required id="selectActor-editar" class="form-control" style="width: 100%;"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="selectPelis"></label>
                                                <input required id="selectPelis-editar" readonly class="form-control" style="width: 100%;"/>
                                                <input id="actor-editar" class="form-control" type="hidden" value="-1">
                                                <input id="registreEntrada-editar" class="form-control" type="hidden" value="-1">
                                                <input id="setmana-editar" class="form-control" type="hidden" value="-1">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="numberTakes-editar" class="mt-3">Takes a realitzar:</label>
                                                <input id="numberTakes-editar" class="form-control" type="number" min="0" readonly>
                                            </div>
                                            <div class="form-group col">
                                                <label for="opcio_calendar-editar" class="mt-3">Opcions:</label>
                                                <select id="opcio_calendar-editar" class="form-control" name="opcio_calendar-editar" disabled="">
                                                    <option value="0" selected>TAKES</option>
                                                    <option value="canço">CANÇO</option>
                                                    <option value="narrador">NARRADOR</option>
                                                    <option value="retakes">RETAKES</option>
                                                    <option value="cues">CUES</option>
                                                    <option value="casting">CASTING</option>
                                                    <option value="trailer">TRAILER</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="takesIni-editar">Hora d'inici:</label>
                                                <input id="takesIni-editar" class="form-control" min="8:30" type="time" readonly>
                                            </div>
                                            <div class="form-group col">
                                                <label for="takesFin-editar">Hora final:</label>
                                                <input id="takesFin-editar" class="form-control" type="time" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="selectDirector"></label>
                                                <input id="selectDirector-editar" readonly class="form-control" style="width: 100%;" placeholder="Selecciona director"/>
                                                <input id="director-editar" class="form-control" type="hidden" value="-1">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-5" id="botonsAfegir" hidden>
                                        <button class="btn btn-success" id="botoAfegir" type="submit">Afegir</button>
                                    </div>
                                    <div class="mt-5" id="botonsModificar" hidden>
                                        <button class="btn btn-primary" id="botoEditar" type="submit">Modificar</button>
                                        <button class="btn btn-danger" id="botoEliminar"  type="submit">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalConf" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">CONFIGURAR - Dia de Festa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="diaInici" class="mt-3">Dia Inici:</label>
                            <input required id="diaInici" class="form-control" type="date">
                        </div>
                        <div class="form-group col">
                            <label for="diaFi" class="mt-3">Dia Final:</label>
                            <input id="diaFi" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="descripcio_festiu">Descripció:</label>
                            <textarea id="descripcio_festiu" class="form-control" type="text"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">TANCAR</button>
                    <button id="btnFesta" type="button" class="btn btn-success">DESA</button>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}" />
<script>
    var week = {{$week}}
    var year = {{$year}}
    var dias = <?php echo json_encode($fechas) ?>;
    var urlBase = "<?php echo $urlBase ?>"
    var data = @json($data);
    var actores = <?php echo $actores ?>;
    var actoresPorDia = @json($actoresPorDia);
    var directors = @json($directors);
    var dataBase = data;   
    var tecnicsAsignados = <?php echo json_encode($tecnicsAsignados) ?>;
    var rutaSearchEmpleat = "{{route('empleatSearch')}}";
    var rutaSearchEntrada = "{{route('registreEntradaSearch')}}";
    var rutaSearchProduccio = "{{route('registreProduccioSearch')}}";
    var festius = @json($festius);
</script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendar.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendarCheck.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendarShowDay.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/custom/calendarPDF.js') }}"></script>
@stop
