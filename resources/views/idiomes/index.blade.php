@extends('layouts.app')

@section('content')

<div class="container">
    <div>
        <a href="{{ url('/idiomes/crear') }}" class="btn btn-success">
            <span class="fas fa-language"></span>
            Afegir idioma
        </a>
    </div>
    <br>
    
    <div class="row">

      @foreach( $idiomes as $key => $idioma )

      <div class="card card-shadow text-center m-3" style="min-width: 250px;">

          <div class="card-body">
              <img src="{{url('/')}}/img/flags/{{$idioma['idioma']}}.png" class="rounded-circle" style="height:50px"/>

              <h4 style="min-height:45px;margin:5px 0 10px 0">
                    {{$idioma['idioma']}}
              </h4>
              <div class="row">
                  <div class="col-6" style="padding: 0px;">
                      <a href="{{ route('idiomaUpdateView', ['id' => $idioma['id_idioma']]) }}" class="btn btn-outline-primary" style="width: 75%;"> Editar </a>
                  </div>
                  <div class="col-6" style="padding: 0px;">
                      <button onclick="setIdiomaPerEsborrar({{$idioma['id_idioma']}}, '{{$idioma['idioma']}}')" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModalCenter"  style="width: 75%;">Esborrar</button>
                      <form id="delete-{{ $idioma['id_idioma'] }}" action="{{ route('idiomaDelete') }}" method="POST">
                          @csrf
                          <input type="hidden" readonly name="id" value="{{$idioma['id_idioma']}}">
                      </form>
                  </div>
              </div>
          </div>
      </div>

      @endforeach

<!-- MODAL ESBORRAR IDIOMA -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Esborrar idioma</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <span id="delete-message">...</span>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setIdiomaPerEsborrar(0)">Tancar</button>
                      <button type="button" class="btn btn-danger" onclick="deleteIdioma()">Esborrar</button>
                  </div>
                  </div>
              </div>
          </div>

  </div>
</div>

<script>
    var idiomaPerEsborrar = 0;

    function setIdiomaPerEsborrar(idiomaId, idiomaAlias) {
        idiomaPerEsborrar = idiomaId;
        if (idiomaAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'idioma <b>' + idiomaAlias + '</b>?';
        }
    }

    function deleteIdioma() {
        if (idiomaPerEsborrar != 0) {
            document.all["delete-" + idiomaPerEsborrar].submit();
        }
    }
</script>


@stop

