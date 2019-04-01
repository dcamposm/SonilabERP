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
    <div style="margin-top: 10px;">
        <div class="llegenda">
            <span style="color: lawngreen; font-size: 30px;">&#9646;</span>
            <span>FINALITZAT</span>
        </div>
        <div class="llegenda">
            <span style="color: darkorange; font-size: 30px;">&#9646;</span>
            <span>PENDENT</span>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>REF</th> 
                <th>SUB.REF</th> 
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

                    <form action="{{ route('deleteRegistre',['id' => $registreProduccio->id]) }}" method="POST">
                        @csrf
                        <a href="{{ route('updateRegistreProduccio', array('id' => $registreProduccio->id )) }}" class="btn btn-primary">MODIFICAR</a>
                        <input type="hidden" readonly name="id" value="{{ $registreProduccio->id }}">
                        <button type="submit" class="btn btn-danger">ESBORRAR</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (isset($return))
        <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
            <span class="fas fa-angle-double-left"></span>
            TORNAR ENRERA
        </a> 
    @endif
</div>

<script>

    var self = this;
    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreProduccio = function (urlShow) {
    window.location.replace(urlShow);
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
