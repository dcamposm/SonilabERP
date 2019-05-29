@extends('layouts.app')

@section('content')

<div class="container">
    <h2 style="font-weight: bold">{{!empty($registreEntrada) ? 'EDITAR REFERENCIA' : 'NOVA REFERÈNCIA'}}</h2>
    <form method = "POST" action="{{ !empty($registreEntrada) ? route('registreEntradaUpdate', array('id' => $registreEntrada->id_registre_entrada)) : route('registreEntradaInsert') }}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">DADES:</legend>
            {{--<!--
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="id_registre_entrada" style="font-weight: bold">REFERENCIA:</label>
                        <input type="number" class="form-control" id="id_registre_entrada" placeholder="Entrar referencia" name="id_registre_entrada" value="{{!empty($registreEntrada) ? $registreEntrada->id_registre_entrada : old('id_registre_entrada')}}">
                        <span class="text-danger">{{ $errors->first('id_registre_entrada') }}</span>
                    </div>
                </div>
            </div>
            -->--}}
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="titol" style="font-weight: bold">TÍTOL:</label>
                        <input type="text" class="form-control" id="titol" name="titol" value="{{!empty($registreEntrada) ? $registreEntrada->titol : old('titol')}}">
                        <span class="text-danger">{{ $errors->first('titol') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="client" style="font-weight: bold">CLIENT:</label>
                        <select class="form-control" name="id_client">
                            <option></option>
                            @foreach( $clients as $client )
                                <option value="{{$client['id_client']}}" {{(!empty($registreEntrada) && $registreEntrada->id_client == $client['id_client']) || (old('id_client') == $client['id_client']) ? 'selected' : ''}} >{{$client['nom_client']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id_client') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="ot" style="font-weight: bold" title=' referència específica del client CCMA.'>OT:</label>
                        <input type="text" class="form-control" id="ot" name="ot" value="{{!empty($registreEntrada) ? $registreEntrada->ot : old('ot')}}">
                        <span class="text-danger">{{ $errors->first('ot') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="oc" style="font-weight: bold" title=" referència específica del client CCMA.">OC:</label>
                        <input type="text" class="form-control" id="oc" name="oc" value="{{!empty($registreEntrada) ? $registreEntrada->oc : old('oc')}}">
                        <span class="text-danger">{{ $errors->first('oc') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="sortida" style="font-weight: bold">DATA PRIMERA ENTREGA:</label>
                        <input type="date" class="form-control" id="sortida" name="sortida" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->sortida)[0] : ''}}">
                        <span class="text-danger">{{ $errors->first('sortida') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="responsable" style="font-weight: bold">RESPONSABLE:</label>
                        <select class="form-control" name="id_usuari">
                            <option></option>
                            @foreach( $usuaris as $usuari )
                                <option value="{{$usuari['id_usuari']}}" {{(!empty($registreEntrada) && $registreEntrada->id_usuari == $usuari['id_usuari']) || (old('id_usuari') == $usuari['id_usuari']) ? 'selected' : ''}} >{{$usuari['alias_usuari'].' '.$usuari['cognom1_usuari'] }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id_usuari') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="servei" style="font-weight: bold">SERVEI:</label>
                        <select class="form-control" name="id_servei">
                            <option></option>
                            @foreach( $serveis as $servei )
                                <option value="{{$servei['id_servei']}}" {{(!empty($registreEntrada) && $registreEntrada->id_servei == $servei['id_servei']) || (old('id_servei') == $servei['id_servei']) ? 'selected' : ''}} >{{$servei['nom_servei']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id_servei') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="idioma" style="font-weight: bold">IDIOMA:</label>
                        <select class="form-control" name="id_idioma">
                            <option></option>
                            @foreach( $idiomes as $idioma )
                                <option value="{{$idioma['id_idioma']}}" {{(!empty($registreEntrada) && $registreEntrada->id_idioma == $idioma['id_idioma']) || (old('id_idioma') == $idioma['id_idioma']) ? 'selected' : ''}} >{{$idioma['idioma']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id_idioma') }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="media" style="font-weight: bold">TIPUS:</label>
                        <select class="form-control" name="id_media" id="id_media">
                            <option></option>
                            @foreach( $medias as $media )
                                <option value="{{$media['id_media']}}" {{(!empty($registreEntrada) && $registreEntrada->id_media == $media['id_media']) || (old('id_media') == $media['id_media']) ? 'selected' : ''}} >{{$media['nom_media']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id_media') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="minuts" style="font-weight: bold">MINUTS TOTALS:</label>
                        <input type="number" class="form-control" id="minuts" name="minuts" value="{{!empty($registreEntrada) ? $registreEntrada->minuts : old('minuts')}}">
                        <span class="text-danger">{{ $errors->first('minuts') }}</span>
                    </div>
                </div>

            </div>
            <div class="row" id="total_ep">
                <div class="col-6">
                    <div class="form-group">
                        <label for="total_episodis" style="font-weight: bold">EPISODIS TOTALS:</label>
                        <input type="number" class="form-control" id="total_episodis" name="total_episodis" value="{{!empty($registreEntrada) ? $registreEntrada->total_episodis : old('total_episodis')}}">
                        <span class="text-danger">{{ $errors->first('total_episodis') }}</span>
                    </div>
                </div>
                <div class="col-6" id="ep_set">
                    <div class="form-group">
                        <label for="episodis_setmanals" style="font-weight: bold">EPISODIS SETMANALS:</label>
                        <input type="number" class="form-control" id="episodis_setmanals" name="episodis_setmanals" value="{{!empty($registreEntrada) ? $registreEntrada->episodis_setmanals : old('episodis_setmanals')}}">                    
                        <span class="text-danger">{{ $errors->first('episodis_setmanals') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6" id="ent_set">
                    <div class="form-group">
                        <label for="entregues_setmanals" style="font-weight: bold">ENTREGUES SETMANALS:</label>
                        <input type="number" class="form-control" id="entregues_setmanals" name="entregues_setmanals" value="{{!empty($registreEntrada) ? $registreEntrada->entregues_setmanals : old('entregues_setmanals')}}">
                        <span class="text-danger">{{ $errors->first('entregues_setmanals') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="estat" style="font-weight: bold">ESTAT:</label>
                        <select class="form-control" name="estat">
                            <option></option>
                            <option value="Pendent" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Pendent') || (old('estat') == 'Pendent') ? 'selected' : ''}}>Pendent</option>
                            <option value="Finalitzada" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Finalitzada') || (old('estat') == 'Finalitzada')  ? 'selected' : ''}}>Finalitzada</option>
                            <option value="Cancel·lada" {{(!empty($registreEntrada) && $registreEntrada->estat == 'Cancel·lada') || (old('estat') == 'Cancel·lada')  ? 'selected' : ''}}>Cancel·lada</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('estat') }}</span>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row justify-content-between mb-3 mt-4">
            <a href="{{ url('/registreEntrada') }}" class="btn btn-primary col-2">
                <span class="fas fa-angle-double-left"></span>
                TORNAR
            </a>

            <button type="submit" class="btn btn-success col-2">{{!empty($registreEntrada) ? 'DESAR CANVIS' : 'CREAR'}} <i class="fas fa-save"></i></button>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ URL::asset('js/custom/registreEntradaCreate.js') }}"></script>
@endsection
