@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ url('/registreEntrada') }}" class="btn btn-primary mt-1">
            <span class="fas fa-angle-double-left"></span>
            TORNAR
        </a>
        <a href="{{ url('/clients/crear') }}" class="btn btn-success mt-1">
            <span class="fas fa-address-book"></span>
            AFEGIR CLIENT
        </a>
    </div>

    {{-- TABLA DE CLIENTS --}}
    <table class="table tableIndex mt-3" style="min-width: 800px;">
        <thead>
            <tr>
                <th><span style="font-size: 11px;">NOM</span></th> 
                <th><span style="font-size: 11px;">EMAIL</span></th>
                <th><span style="font-size: 11px;">TELÈFON</span></th>
                <th><span style="font-size: 11px;">ACCIONS</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach( $clients as $key => $client )
            <tr>
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarClient('{{ route('mostrarClient', array('id' => $client->id_client)) }}')">
                    <span class="font-weight-bold" style="font-size: 11px;">{{ $client->nom_client }}</span>
                </td>
                <td style="vertical-align: middle; font-size: 11px;">{{ $client->email_client }}</td>
                <td style="vertical-align: middle; font-size: 11px;">{{ $client->telefon_client }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('clientUpdateView', array('id' => $client['id_client'])) }}" class="btn btn-primary btn-sm"><span style="font-size: 11px;">MODIFICAR</span></a>
                    <button class="btn btn-danger btn-sm" onclick="self.seleccionarClient({{ $client['id_client'] }}, '{{ $client['nom_client'] }}')" data-toggle="modal" data-target="#exampleModalCenter"><span style="font-size: 11px;">ESBORRAR</span></button>
                    <form id="delete-{{ $client['id_client'] }}" action="{{ route('esborrarClient') }}" method="POST">
                        @csrf
                        <input type="hidden" readonly name="id" value="{{ $client['id_client'] }}">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- MODAL ESBORRAR CLIENT -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Esborrar client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="delete-message">...</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="self.seleccionarClient(0)">Tancar</button>
                    <button type="button" class="btn btn-danger" onclick="self.esborrarClient()">Esborrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var self = this;
    self.clientPerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un client.
    self.mostrarClient = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un client i mostra un missatge en el modal d'esborrar.
    self.seleccionarClient = function (clientId, clientAlias) {
        self.clientPerEsborrar = clientId;
        if (clientAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el client <b>' + clientAlias + '</b>?';
        }
    }

    // Esborra el client seleccionat.
    self.esborrarClient = function () {
        if (self.clientPerEsborrar != 0) {
            document.all["delete-" + self.clientPerEsborrar].submit(); 
        }
    }
</script>


@stop
