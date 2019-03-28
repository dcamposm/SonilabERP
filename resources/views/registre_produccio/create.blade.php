@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="mb-4">{{!empty($registreProduccio) ? 'Modificació' : 'Creació' }} de registres de producció</h2>
  <div class="row">
    {{-- DADES BÀSIQUES --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreBasic',array('id' => $registreProduccio->id)) : route('createRegistreBasic')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">Dades bàsiques</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>Desar
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="id_registre_entrada">Referència</label>
              <select name="id_registre_entrada" id="id_registre_entrada" class="form-control">
                @foreach ($regEntrades as $key => $entrada) 
                  <option value="{{ $entrada->id_registre_entrada }}" {{(!empty($registreProduccio) && $entrada->id_registre_entrada == $registreProduccio->id_registre_entrada) ? 'selected' : '' }} >{{ $entrada->titol }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="subreferencia">Sub-referència</label>
              <input type="text" name="subreferencia" id="subreferencia" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->id : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_entrega">Data d'entrega</label>
              <input type="date" name="data_entrega" id="data_entrega" class="form-control" value="{{!empty($registreProduccio) ? explode(' ',$registreProduccio->data_entrega)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="setmana">Setmana</label>
              <input type="number" name="setmana" id="setmana" class="form-control" min="0" value="{{!empty($registreProduccio) ? $registreProduccio->setmana : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="titol">Títol</label>
              <input type="text" name="titol" id="titol" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->titol : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="titol_traduit">Títol traduït</label>
              <input type="text" name="titol_traduit" id="titol_traduit" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->titol_traduit : ''}}">
            </div>

            {{-- NOTA: data_mix NO EXISTE todavía en la base de datos --}}
            <div class="form-group col-12 col-sm-6">
              <label for="data_mix" title="data en que la mescla ha d'estar acabada">Data mix</label>
              <input type="date" name="data_mix" id="data_mix" class="form-control" value="{{!empty($registreProduccio) ? explode(' ',$registreProduccio->data_tecnic_mix)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="estat">Estat</label>
              <select name="estat" id="estat" class="form-control">
                <option value="Pendent" {{(!empty($registreProduccio) && "Pendent" == $registreProduccio->estat) ? 'selected' : '' }}>Pendent</option>
                <option value="Finalitzada" {{(!empty($registreProduccio) && "Finalitzada" == $registreProduccio->estat) ? 'selected' : '' }}>Finalitzada</option>
                <option value="Cancel·lada" {{(!empty($registreProduccio) && "Cancel·lada" == $registreProduccio->estat) ? 'selected' : '' }}>Cancel·lada</option>
              </select>
            </div>
          </div>
        </form> {{-- end form --}}
      </div>
    </div>

    {{-- COMANDA --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreComanda',array('id' => $registreProduccio->id)) : route('createRegisteComanda')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">Comanda</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>Desar
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="estadillo">Estadillo</label>
              <select name="estadillo" id="estadillo" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->estadillo) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->estadillo) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="propostes">Propostes</label>
              <select name="propostes" id="propostes" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->propostes) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->propostes) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="retakes">Retakes</label>
              <select name="retakes" id="retakes" class="form-control">
                <option value="No" {{(!empty($registreProduccio) && "No" == $registreProduccio->retakes) ? 'selected' : '' }}>No</option>
                <option value="Si" {{(!empty($registreProduccio) && "Si" == $registreProduccio->retakes) ? 'selected' : '' }}>Sí</option>
                <option value="Fet" {{(!empty($registreProduccio) && "Fet" == $registreProduccio->retakes) ? 'selected' : '' }}>Fet</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="subtitol">Sub-títol</label>
              <input type="text" name="subtitol" id="subtitol" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->subtitol : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="qc_mix" title="control de qualitat de la mescla">QC MIX</label>
              <select name="qc_mix" id="qc_mix" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_mix) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_mix) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="ppe" title="Preparat per entregar">PPE</label>
              <select name="ppe" id="ppe" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->ppe) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->ppe) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

          </div>
        </form> {{-- end form --}}
      </div>
    </div>

    {{-- EMPLEATS --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreEmpleats',array('id' => $registreProduccio->id)) : route('createRegistreEmpleats')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">Empleats</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>Desar
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="id_traductor">Traductor</label>
              <select name="id_traductor" id="id_traductor" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                  <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_traductor) ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_traductor">Data traductor</label>
              <input type="date" name="data_traductor" id="data_traductor" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_traductor)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_ajustador">Ajustador</label>
              <select name="id_ajustador" id="id_ajustador" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                  <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_ajustador) ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_ajustador">Data ajustador</label>
              <input type="date" name="data_ajustador" id="data_ajustador" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_ajustador)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_linguista">Lingüista</label>
              <select name="id_linguista" id="id_linguista" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                  <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_linguista) ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_linguista">Data lingüista</label>
              <input type="date" name="data_linguista" id="data_linguista" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_linguista)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_tecnic_mix">Tècnic mix</label>
              <select name="id_tecnic_mix" id="id_tecnic_mix" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                  <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_tecnic_mix) ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_tecnic_mix">Data tècnic mix</label>
              <input type="date" name="data_tecnic_mix" id="data_tecnic_mix" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_tecnic_mix)[0] : ''}}">
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_director">Director</label>
              <select name="id_director" id="id_director" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                  <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_director) ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                @endforeach
              </select>
            </div>

          </div>
        </form> {{-- end form --}}
      </div>
    </div>

    {{-- PREPARACIÓ --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistrePreparacio',array('id' => $registreProduccio->id)) : route('createRegistrePreparacio')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">Preparació</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>Desar
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
                <label for="qc_vo" title="control de qualitat de la versió original">QC VO</label>
              <select name="qc_vo" id="qc_vo" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_vo) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_vo) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="qc_me" title="control de qualitat del soundtrack">QC M&E</label>
              <select name="qc_me" id="qc_me" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_me) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_me) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="ppp" title="preparat per producció">PPP</label>
              <select name="ppp" id="ppp" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->ppp) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->ppp) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="casting">Càsting</label>
              <select name="casting" id="casting" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->casting) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->casting) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="inserts">Inserts</label>
              <select name="inserts" id="inserts" class="form-control">
                <option value="No cal fer" {{(!empty($registreProduccio) && "No cal fer" == $registreProduccio->inserts) ? 'selected' : '' }}>No cal fer</option>
                <option value="Cal fer" {{(!empty($registreProduccio) && "Cal fer" == $registreProduccio->inserts) ? 'selected' : '' }}>Cal fer</option>
                <option value="Fet" {{(!empty($registreProduccio) && "Fet" == $registreProduccio->inserts) ? 'selected' : '' }}>Fet</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="vec" title="valoració econòmica">VEC</label>
              <select name="vec" id="vec" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->vec) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->vec) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>
            
          </div>
        </form> {{-- end form --}}
      </div>
    </div>

    {{-- CONVOCATORIA --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreConvocatoria',array('id' => $registreProduccio->id)) : route('createRegistreConvocatoria')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">Convocatòria</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>Desar
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="convos" title="Activar quan s'hagin convocat tots els actors">Convos</label>
              <select name="convos" id="convos" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->convos) ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->convos) ? 'selected' : '' }}>Sí</option>
              </select>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="inici_sala">Inici sala</label>
              <input type="date" name="inici_sala" id="inici_sala" class="form-control" value={{!empty($registreProduccio) ? explode(' ', $registreProduccio->inici_sala)[0] : ''}}>
            </div>
          </div>
        </form> {{-- end form --}}
      </div>
    </div>

  </div>
</div>

@endsection
