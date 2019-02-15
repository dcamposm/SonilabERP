@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <a href="{{ url('/clients/crear') }}" class="btn btn-success">
            <span class="fas fa-atlas"></span>
            Afegir client
        </a>
    </div>
    <br>
    {{-- TABLA DE CLIENTS --}}
    <table class="table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Nom</th> 
                <th>Email</th>
                <th>Telefon</th>
                <th>Direcció</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $clients as $key => $client )
            <tr>
                <td class="cursor" style="vertical-align: middle;" onclick="self.mostrarClient('{{ route('mostrarClient', array('id' => $client->id_client)) }}')">
                    <span class="font-weight-bold" style="font-size: 1rem;">{{ $client->nom_client }}</span>
                </td>
                <td style="vertical-align: middle;">{{ $client->email_client }}</td>
                <td style="vertical-align: middle;">{{ $client->telefon_client }}</td>
                <td style="vertical-align: middle;">{{ $client->direccio_client }}</td>
                <td style="vertical-align: middle;">
                    <a href="{{ route('clientUpdateView', array('id' => $client['id_client'])) }}" class="btn btn-primary">Modificar</a>
                    <button class="btn btn-danger" onclick="self.seleccionarClient({{ $client['id_client'] }}, '{{ $client['nom_client'] }}')" data-toggle="modal" data-target="#exampleModalCenter">Esborrar</button>
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
