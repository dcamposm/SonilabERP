@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        @if(Auth::user()->hasAnyRole(['1','2','4']))
        <div class="col-3">
            <a href="{{ url('/registreProduccio/crear') }}" class="btn btn-success">
                <span class="fas fa-atlas"></span>
                Afegir registre de producció
            </a>
        </div>
        @endif
    </div>

    {{-- LEYENDA DE COLORES DE ESTADO --}}
    <div style="margin-top: 10px;">
        <div class="llegenda">
            <span style="color: lawngreen; font-size: 30px;">&#9646;</span>
            <span>Finalitzat</span>
        </div>
        <div class="llegenda">
            <span style="color: darkorange; font-size: 30px;">&#9646;</span>
            <span>Pendent</span>
        </div>
        <div style="clear:both;"></div>
    </div>

    {{-- TABLA DE REGISTROS DE ENTRADA --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>REF</th> 
                <th>Sub.Ref</th> 
                <th>Data d'entrega</th>
                <th>Setmana</th>
                <th>Títol Original</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $registreProduccions as $key => $registreProduccio )
            <tr class="table-selected {{ ($registreProduccio->estat == 'Pendent') ? 'border-warning' : (($registreProduccio->estat == 'Finalitzada') ? 'border-success' : 'border-danger') }}">
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarRegistreProduccio('{{ route('mostrarRegistreProduccio', array('id' => $registreProduccio->id)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $registreProduccio->id_registre_entrada }}</span>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    
    var self = this;
    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreProduccio = function (urlShow) {
    window.location.replace(urlShow);
    }

    


</script>


@stop