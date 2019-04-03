@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        @if(Auth::user()->hasAnyRole(['1','2','4']))
        <div class="col">
            <a href="{{ url('/registreProduccio/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                AFEGIR REGISTRE DE PRODUCCIÓ
            </a>
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <a href="{{ url('/estadillos') }}" class="btn btn-success">
                <span class="fas fa-clipboard-list"></span>
                ESTADILLOS
            </a>
            @endif
        </div>
        @endif
        <!-- FILTRA REGISTRE PRODUCCIO -->
        <div class="row">
            <div class="col">
                <form method = "GET" action= '{{ route('registreProduccioFind') }}' id='search'>
                    @csrf
                    <div class="input-group">
                        <select class="custom-select" id='searchBy' name="searchBy" form="search">
                            <option selected>BUSCAR PER...</option>
                            <option value='1'>REFERENCIA</option>
                            <option value="2">PRODUCCIÓ</option>
                            <option value="3">ESTAT</option>
                        </select>
                        <input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar registre...">

                        <select class="custom-select" id='search_Estat' name="search_Estat" form="search" style="display: none;">
                            <option value="Pendent">PENDENT</option>
                            <option value="Cancel·lada">CANCEL·LADA</option>
                        </select>

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" type="button"><span class="fas fa-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div class="d-flex justify-content-end" style="margin-top: 10px;">
        <div class="llegenda">
            <span style="color: lawngreen; font-size: 15px;">&#9646;</span>
            <span style="font-size: 11px; padding: 1px;">FINALITZAT</span>
        </div>
        <div class="llegenda">
            <span style="color: darkorange; font-size: 15px;">&#9646;</span>
            <span style="font-size: 11px; padding: 1px;">PENDENT</span>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>REF.</th> 
                <th>SUB-REF</th> 
                <th>DATA D'ENTRADA</th>
                <th>SETMANA</th>
                <th>TÍTOL ORIGINAL</th>
                <th>ACCIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $registreProduccions as $key => $registreProduccio )
            <tr class="table-selected {{ ($registreProduccio->estat == 'Pendent') ? 'border-warning' : (($registreProduccio->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                <td class="cursor" title='Veure registre d&apos;entrada' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreEntrada', array('id' => $registreProduccio->id_registre_entrada)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $registreProduccio->id_registre_entrada }}</span>    
                </td>
                <td class="cursor" title='Veure producció' style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $registreProduccio->subreferencia }}</span>
                </td>
                <td style="vertical-align: middle;">{{ date('d/m/Y', strtotime($registreProduccio->data_entrega)) }}</td>
                <td style="vertical-align: middle;">{{$registreProduccio->setmana}}</td>
                <td style="vertical-align: middle;">{{$registreProduccio->titol}}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('updateRegistreProduccio', array('id' => $registreProduccio->id )) }}" class="btn btn-primary">MODIFICAR</a>
                    @if (Auth::user()->hasAnyRole(['4']))
                        <button class="btn btn-danger" onclick="self.seleccionarRegistreProduccio({{ $registreProduccio->id }}, '{{ $registreProduccio->id_registre_entrada.' '.$registreProduccio->titol.' '.$registreProduccio->subreferencia }}')" data-toggle="modal" data-target="#exampleModalCenter">ESBORRAR</button>
                        <form id="delete-{{ $registreProduccio->id }}" action="{{ route('deleteRegistre') }}" method="POST">
                            @csrf
                            <input type="hidden" readonly name="id" value="{{ $registreProduccio->id }}">
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- MODAL ESBORRAR REGISTRE ENTRADA -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ESBORRAR REGISTRE PRODUCCIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarRegistreProduccio(0)">TANCAR</button>
                    <button type="button" class="btn btn-danger" onclick="self.deleteRegistre()">ESBORRAR</button>
                </div>
            </div>
        </div>
    </div>
    
    @if (isset($return))
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR ENRERA
        </a> 
    @endif
</div>

<script>

    var self = this;
    self.registrePerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreProduccio = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un registre d'entrada i mostra un missatge en el modal d'esborrar.
    self.seleccionarRegistreProduccio = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el registre de producció <b>' + registreProduccioAlias + '</b>?';
        }
    }

    // Esborra el registre d'entrada seleccionat.
    self.deleteRegistre = function () {
        if (self.registrePerEsborrar != 0) {
            document.all["delete-" + self.registrePerEsborrar].submit(); 
        }
    }

//--------Funcions per el filtra-----------
    function selectSearch() {
    //var value = $('#searchBy').val();

    //alert(value);
    if ($('#searchBy').val() == '3') {
        $('#search_term').hide();
        $('#search_Estat').show();
    }
    else {
        $('#search_term').show();
        $('#search_Estat').hide();
    }
    }

    $('#searchBy').change(selectSearch);
</script>


</script>


@stop
