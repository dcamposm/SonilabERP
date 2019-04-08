@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <h2 class="mb-4">{{!empty($registreProduccio) ? 'Modificació' : 'Creació' }} de registre de producció</h2>
  <div class="row">
    
    {{-- DADES BÀSIQUES --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreBasic',array('id' => $registreProduccio->id)) : route('createRegistreBasic')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">DADES BÀSIQUES</span>
            @if (Auth::user()->hasAnyRole(['1', '2', '4']))
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>DESAR
            </button>
            @endif
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="id_registre_entrada">REFERÈNCIA</label>
              <select name="id_registre_entrada" id="id_registre_entrada" class="form-control">
                @foreach ($regEntrades as $key => $entrada) 
                  <option value="{{ $entrada->id_registre_entrada }}" {{(!empty($registreProduccio) && $entrada->id_registre_entrada == $registreProduccio->id_registre_entrada)  || old('id_registre_entrada') ? 'selected' : '' }} >{{ $entrada->id_registre_entrada }} {{ $entrada->titol }}</option>
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_registre_entrada') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="subreferencia">SUB-REFERÈNCIA</label>
              <input type="text" name="subreferencia" id="subreferencia" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->subreferencia : old('subreferencia')}}">
              <span class="text-danger">{{ $errors->first('subreferencia') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_entrega">DATA D'ENTREGA</label>
              <input type="date" name="data_entrega" id="data_entrega" class="form-control" value="{{!empty($registreProduccio) ? explode(' ',$registreProduccio->data_entrega)[0] : old('data_entrega')}}">
              <span class="text-danger">{{ $errors->first('data_entrega') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="setmana">SETMANA</label>
              <input type="number" name="setmana" id="setmana" class="form-control" min="0" value="{{!empty($registreProduccio) ? $registreProduccio->setmana : old('setmana')}}">
              <span class="text-danger">{{ $errors->first('setmana') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="titol">TÍTOL ORIGINAL</label>
              <input type="text" name="titol" id="titol" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->titol : old('titol')}}">
              <span class="text-danger">{{ $errors->first('titol') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="estat">ESTAT</label>
              <select name="estat" id="estat" class="form-control">
                <option value="Pendent" {{(!empty($registreProduccio) && "Pendent" == $registreProduccio->estat) || old('estat') ? 'selected' : '' }}>Pendent</option>
                <option value="Finalitzada" {{(!empty($registreProduccio) && "Finalitzada" == $registreProduccio->estat) || old('estat') ? 'selected' : '' }}>Finalitzada</option>
                <option value="Cancel·lada" {{(!empty($registreProduccio) && "Cancel·lada" == $registreProduccio->estat) || old('estat') ? 'selected' : '' }}>Cancel·lada</option>
              </select>
              <span class="text-danger">{{ $errors->first('estat') }}</span>
            </div>
          </div>
        </form> {{-- end form --}}
      </div>
    </div>

    @if (Auth::user()->hasAnyRole(['1', '2', '4']))
    {{-- COMANDA --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreComanda',array('id' => $registreProduccio->id)) : route('createRegisteComanda')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">COMANDA</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>DESAR
            </button>
          </div>
          <div class="card-body row">
            
            <div class="form-group col-12 col-sm-6">
              <label for="propostes">PROPOSTES</label>
              <select name="propostes" id="propostes" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->propostes) || old('propostes') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->propostes) || old('propostes') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('propostes') }}</span>
            </div>
            
            <div class="form-group col-12 col-sm-6">
              <label for="titol_traduit">TÍTOL TRADUÏT</label>
              <input type="text" name="titol_traduit" id="titol_traduit" class="form-control" value="{{!empty($registreProduccio) ? $registreProduccio->titol_traduit : old('titol_traduit')}}">
              <span class="text-danger">{{ $errors->first('titol_traduit') }}</span>
            </div>
            
            <div class="form-group col-12 col-sm-6">
                <label for="inserts">INSERTS</label>
                <select name="inserts" id="inserts" class="form-control">
                  <option value="No cal fer" {{(!empty($registreProduccio) && "No cal fer" == $registreProduccio->inserts) || old('inserts') ? 'selected' : '' }}>No cal fer</option>
                  <option value="Cal fer" {{(!empty($registreProduccio) && "Cal fer" == $registreProduccio->inserts) || old('inserts') ? 'selected' : '' }}>Cal fer</option>
                  <option value="Fet" {{(!empty($registreProduccio) && "Fet" == $registreProduccio->inserts) || old('inserts') ? 'selected' : '' }}>Fet</option>
                </select>
                <span class="text-danger">{{ $errors->first('inserts') }}</span>
            </div>
              
            <div class="form-group col-12 col-sm-6">
              <label for="estadillo">ESTADILLO</label>
              <select name="estadillo" id="estadillo" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->estadillo) || old('estadillo') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->estadillo) || old('estadillo') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('estadillo') }}</span>
            </div>
             
            <div class="form-group col-12 col-sm-6">
              <label for="vec" title="valoració econòmica">VEC</label>
              <select name="vec" id="vec" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->vec) || old('vec') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->vec) || old('vec') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('vec') }}</span>
            </div>
            
            <div class="form-group col-12 col-sm-6">
              <label for="data_tecnic_mix">DATA MIX</label>
              <input type="date" name="data_tecnic_mix" id="data_tecnic_mix" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_tecnic_mix)[0] : old('data_tecnic_mix')}}">
              <span class="text-danger">{{ $errors->first('data_tecnic_mix') }}</span>
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
            <span class="h3">EMPLEATS</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>DESAR
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
              <label for="id_traductor">TRADUCTOR</label>
              <select name="id_traductor" id="id_traductor" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                    @foreach ($empleat->carrec as $key => $carrec) 
                        @if ($carrec->id_tarifa == 12)
                            <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_traductor) || old('id_traductor') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                        @endif
                    @endforeach
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_traductor') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_traductor">DATA TRADUCTOR</label>
              <input type="date" name="data_traductor" id="data_traductor" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_traductor)[0] : old('data_traductor')}}">
              <span class="text-danger">{{ $errors->first('data_traductor') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_ajustador">AJUSTADOR</label>
              <select name="id_ajustador" id="id_ajustador" class="form-control">
                @foreach ($empleats as $key => $empleat)
                    @foreach ($empleat->carrec as $key => $carrec) 
                        @if ($carrec->id_tarifa == 13)
                            <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_ajustador) || old('id_ajustador') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                        @endif
                    @endforeach
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_ajustador') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_ajustador">DATA AJUSTADOR</label>
              <input type="date" name="data_ajustador" id="data_ajustador" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_ajustador)[0] : old('data_ajustador')}}">
              <span class="text-danger">{{ $errors->first('data_ajustador') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_linguista">LINGÜISTA</label>
              <select name="id_linguista" id="id_linguista" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                    @foreach ($empleat->carrec as $key => $carrec) 
                        @if ($carrec->id_tarifa == 14)
                            <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_linguista) || old('id_linguista') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                        @endif
                    @endforeach
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_linguista') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="data_linguista">DATA LINGÜISTA</label>
              <input type="date" name="data_linguista" id="data_linguista" class="form-control" value="{{!empty($registreProduccio) ? explode(' ', $registreProduccio->data_linguista)[0] : old('data_linguista')}}">
              <span class="text-danger">{{ $errors->first('data_linguista') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="id_director">DIRECTOR</label>
              <select name="id_director" id="id_director" class="form-control">
                @foreach ($empleats as $key => $empleat)
                    @foreach ($empleat->carrec as $key => $carrec) 
                        @if ($carrec->id_tarifa == 1 || $carrec->id_tarifa == 2)
                            <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_director) || old('id_director') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                            @break
                        @endif
                    @endforeach
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_director') }}</span>
            </div>
              

            <div class="form-group col-12 col-sm-6">
              <label for="casting">CÀSTING</label>
              <select name="casting" id="casting" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->casting) || old('casting') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->casting) || old('casting') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('casting') }}</span>
            </div>  
            </div>
        </form> {{-- end form --}}
      </div>
    </div>
    @endif
    @if (Auth::user()->hasAnyRole(['1', '3', '4']))
    {{-- PREPARACIÓ --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistrePreparacio',array('id' => $registreProduccio->id)) : route('createRegistrePreparacio')}}"> {{-- init form --}}
          <div class="card-header">
            <span class="h3">PREPARACIÓ</span>
            <button class="btn btn-success float-right">
              <span class="fas fa-save"></span>DESAR
            </button>
          </div>
          <div class="card-body row">
            <div class="form-group col-12 col-sm-6">
                <label for="qc_vo" title="control de qualitat de la versió original">QC VO</label>
              <select name="qc_vo" id="qc_vo" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_vo) || old('qc_vo') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_vo) || old('qc_vo') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('qc_vo') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="qc_me" title="control de qualitat del soundtrack">QC M&E</label>
              <select name="qc_me" id="qc_me" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_me) || old('qc_me') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_me) || old('qc_me') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('qc_me') }}</span>
            </div>
            
            <div class="form-group col-12 col-sm-6">
              <label for="qc_mix" title="Control de qualitat de la mescla">QC MIX</label>
              <select name="qc_mix" id="qc_mix" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->qc_mix) || old('qc_mix') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->qc_mix) || old('qc_mix') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('qc_mix') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="ppp" title="preparat per producció">PPP</label>
              <select name="ppp" id="ppp" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->ppp) || old('ppp') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->ppp) || old('ppp') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('ppp') }}</span>
            </div>
            
            <div class="form-group col-12 col-sm-6">
              <label for="pps" title="preparat per producció">PPS</label>
              <select name="pps" id="pps" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->pps) || old('pps') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->pps) || old('pps') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('pps') }}</span>
            </div>
              
            <div class="form-group col-12 col-sm-6">
              <label for="ppe" title="Preparat per entregar">PPE</label>
              <select name="ppe" id="ppe" class="form-control">
                <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->ppe) || old('ppe') ? 'selected' : '' }}>No</option>
                <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->ppe) || old('ppe') ? 'selected' : '' }}>Sí</option>
              </select>
              <span class="text-danger">{{ $errors->first('ppe') }}</span>
            </div>  
              
            <div class="form-group col-12 col-sm-6">
              <label for="id_tecnic_mix">TÈCNIC MIX</label>
              <select name="id_tecnic_mix" id="id_tecnic_mix" class="form-control">
                @foreach ($empleats as $key => $empleat) 
                    @foreach ($empleat->carrec as $key => $carrec) 
                        @if ($carrec->id_tarifa == 3 || $carrec->id_tarifa == 4)
                            <option value="{{ $empleat->id_empleat }}" {{(!empty($registreProduccio) && $empleat->id_empleat == $registreProduccio->id_tecnic_mix) || old('id_tecnic_mix') ? 'selected' : '' }}>{{ $empleat->nom_empleat }} {{ $empleat->cognom1_empleat }} {{ $empleat->cognom2_empleat }}</option>
                            @break
                        @endif
                    @endforeach
                @endforeach
              </select>
              <span class="text-danger">{{ $errors->first('id_tecnic_mix') }}</span>
            </div>
          </div>
        </form> {{-- end form --}}
      </div>
    </div>
    @endif
    @if (Auth::user()->hasAnyRole(['1', '2', '4']))
    {{-- CONVOCATORIA --}}
    <div class="col-12 col-xl-6 mb-3">
      <div class="card">
        <form method="POST" action="{{!empty($registreProduccio) ? route('updateRegistreConvocatoria',array('id' => $registreProduccio->id)) : route('createRegistreConvocatoria')}}"> {{-- init form --}}
            
            <div class="card-header">
                <span class="h3">CONVOCATÒRIA</span>
                <button class="btn btn-success float-right">
                  <span class="fas fa-save"></span>DESAR
                </button>
            </div>
            <div class="card-body row">
              <div class="form-group col-12 col-sm-6">
                <label for="convos" title="Activar quan s'hagin convocat tots els actors">CONVOS</label>
                <select name="convos" id="convos" class="form-control">
                  <option value="0" {{(!empty($registreProduccio) && "0" == $registreProduccio->convos) || old('convos') ? 'selected' : '' }}>No</option>
                  <option value="1" {{(!empty($registreProduccio) && "1" == $registreProduccio->convos) || old('convos') ? 'selected' : '' }}>Sí</option>
                </select>
                <span class="text-danger">{{ $errors->first('convos') }}</span>
            </div>

            <div class="form-group col-12 col-sm-6">
              <label for="inici_sala">INICI SALA</label>
              <input type="date" name="inici_sala" id="inici_sala" class="form-control" value={{!empty($registreProduccio) ? explode(' ', $registreProduccio->inici_sala)[0] : old('inici_sala')}}>
              <span class="text-danger">{{ $errors->first('inici_sala') }}</span>
            </div>
                
            <div class="form-group col-12 col-sm-6">
              <label for="final_sala">FINAL SALA</label>
              <input type="date" name="final_sala" id="final_sala" class="form-control" value={{!empty($registreProduccio) ? explode(' ', $registreProduccio->final_sala)[0] : old('final_sala')}}>
              <span class="text-danger">{{ $errors->first('final_sala') }}</span>
            </div>           

            <div class="form-group col-12 col-sm-6">
              <label for="retakes">RETAKES</label>
              <select name="retakes" id="retakes" class="form-control">
                <option value="No" {{(!empty($registreProduccio) && "No" == $registreProduccio->retakes) || old('retakes') ? 'selected' : '' }}>No</option>
                <option value="Si" {{(!empty($registreProduccio) && "Si" == $registreProduccio->retakes) || old('retakes') ? 'selected' : '' }}>Sí</option>
                <option value="Fet" {{(!empty($registreProduccio) && "Fet" == $registreProduccio->retakes) || old('retakes') ? 'selected' : '' }}>Fet</option>
              </select>
              <span class="text-danger">{{ $errors->first('retakes') }}</span>
            </div>
  
          </div>
        </form> {{-- end form --}}
      </div>
    </div>
    @endif
  </div>
    <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
      <span class="fas fa-angle-double-left"></span>
      TORNAR
    </a> 
</div>

@endsection
