@extends('layouts.app')

@section('content')

<?php 
use Carbon\Carbon; 
$fecha16AnyosMenos = Carbon::now()->subYears(16)->format('Y-m-d');
?>

<div class="container">
    <h2 style="font-weight: bold">{{!empty($empleat) ? 'Editar empleat' : 'Crear empleat'}}</h2>
    <form method = "POST" action="{{!empty($empleat) ? route('empleatUpdate', ['id' => $empleat->id_empleat]) : route('empleatInsert')}}" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades personals:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="nom_empleat" style="font-weight: bold">Nom:</label>
                        <input type="text" class="form-control" id="nom_empleat" placeholder="Entrar nom" name="nom_empleat" value="{{!empty($empleat) ? $empleat->nom_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('nom_empleat') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email_empleat" style="font-weight: bold">Email:</label>
                        <input type="email" class="form-control" id="email_empleat" placeholder="Entrar correu" name="email_empleat" value="{{!empty($empleat) ? $empleat->email_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('email_empleat') }}</span>
                    </div> 
                </div>
                
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="cognom1_empleat" style="font-weight: bold">Primer Cognom:</label>
                        <input type="text" class="form-control" id="cognom1_empleat" placeholder="Entrar primer cognom" name="cognom1_empleat" value="{{!empty($empleat) ? $empleat->cognom1_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('cognom1_empleat') }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="cognom2_empleat" style="font-weight: bold">Segon Cognom:</label>
                        <input type="text" class="form-control" id="cognom2_empleat" placeholder="Entrar segon cognom" name="cognom2_empleat" value="{{!empty($empleat) ? $empleat->cognom2_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('cognom2_empleat') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="sexe_empleat" style="font-weight: bold">Sexe:</label>
                        <select class="form-control" name="sexe_empleat">
                            <option value="Dona" {{(!empty($empleat) && $empleat->sexe_empleat == 'Dona') ? 'selected' : ''}}>Dona</option>
                            <option value="Home" {{(!empty($empleat) && $empleat->sexe_empleat == 'Home') ? 'selected' : ''}}>Home</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('sexe_empleat') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nacionalitat" style="font-weight: bold">Nacionalitat:</label>
                        <input type="text" class="form-control" id="nacionalitat_empleat" placeholder="Entrar nacionalitat" name="nacionalitat_empleat" value="{{!empty($empleat) ? $empleat->nacionalitat_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('nacionalitat_empleat') }}</span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="dni_empleat" style="font-weight: bold">DNI:</label>
                        <input type="text" class="form-control" id="dni_empleat" placeholder="Entrar DNI empleat" name="dni_empleat" value="{{!empty($empleat) ? $empleat->dni_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('dni_empleat') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="telefon_empleat" style="font-weight: bold">Telèfon:</label>
                        <input type="tel" class="form-control" id="telefon_empleat" placeholder="Entrar telèfon empleat" name="telefon_empleat" value="{{!empty($empleat) ? $empleat->telefon_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('telefon_empleat') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="direccio_empleat" style="font-weight: bold">Direcció:</label>
                        <input type="text" class="form-control" id="direccio_empleat" placeholder="Entrar direcció empleat" name="direccio_empleat" value="{{!empty($empleat) ? $empleat->direccio_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('direccio_empleat') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="codi_postal_empleat" style="font-weight: bold">Codi postal:</label>
                        <input type="number" class="form-control" id="codi_postal_empleat" placeholder="Entrar codi postal empleat" name="codi_postal_empleat" value="{{!empty($empleat) ? $empleat->codi_postal_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('codi_postal_empleat') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="naixement_empleat" style="font-weight: bold">Data naixement:</label>
                        <input type="date" max="{{$fecha16AnyosMenos}}" value="{{$fecha16AnyosMenos}}" class="form-control" id="naixement_empleat" placeholder="Entrar data naixement empleat" name="naixement_empleat" value="{{!empty($empleat) ? explode(' ',$empleat->naixement_empleat)[0] : ''}}">
                        <span class="text-danger">{{ $errors->first('naixement_empleat') }}</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nss_empleat" style="font-weight: bold">NSS:</label>
                        <input type="text" class="form-control" id="nss_empleat" placeholder="Entrar número seguretat social empleat" name="nss_empleat" value="{{!empty($empleat) ? $empleat->nss_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('nss_empleat') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="iban_empleat" style="font-weight: bold">IBAN:</label>
                        <input type="text" class="form-control" id="iban_empleat" placeholder="Entrar IBAN empleat" name="iban_empleat" value="{{!empty($empleat) ? $empleat->iban_empleat : ''}}">
                        <span class="text-danger">{{ $errors->first('iban_empleat') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label for="imatge_empleat" style="font-weight: bold">Imatge Empleat:</label>
                    <input type="file" name="imatge_empleat" />
                </div>
            </div>

        </fieldset>
        <fieldset class="border p-2">
            <legend class="w-auto">Càrrecs:</legend>

            <!-- CHECKBOX PARA ACTIVAR CARGOS -->
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="director" style="font-weight: bold">Director:</label>
                        <input type="checkbox" onchange="mostrarCamps('director')" class="form-control" id="director" name="director" {{ isset($carrecs['director']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tecnic_sala" style="font-weight: bold">Tècnic:</label>
                        <input type="checkbox" onchange="mostrarCamps('tecnic')" class="form-control" id="tecnic_sala" name="tecnic_sala" {{ isset($carrecs['tecnic_sala']) ? 'checked' : ''}} value="1">
                    </div>
                </div>               
                <div class="col">
                    <div class="form-group">
                        <label for="actor" style="font-weight: bold">Actor:</label>
                        <input type="checkbox" onchange="mostrarCamps('actor')" class="form-control" id="actor" name="actor" {{ isset($carrecs['actor']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="traductor" style="font-weight: bold">Traductor, Ajustador i Lingüista:</label>
                        <input type="checkbox" onchange="mostrarCamps('traductor')" class="form-control" id="traductor" name="traductor" {{ isset($carrecs['traductor']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
            </div>

            <!-- CARGOS: DIRECTOR, TÉCNICO DE SALA -->
            <div class="row">
                
                
                <div class="col-12" id="colDirector" style="display:{{ isset($carrecs['director']) ? '' : 'none'}}">

                    <div class="form-group" style="width:100%;">
                       <div style="width:30%; float:left">
                            <label for="director_tarifas" style="font-weight: bold">Selección de tarifas director:</label>
                            <select onchange="mostrarCamposTarifas(event,'director')" id="director_tarifas" multiple class="form-control">
                                <option value="-1" disabled>Selecciona una tarifa</option>
                                @foreach( $tarifas as $key => $tarifa)
                                    @if($tarifa->id_carrec == 2)
                                        <option value="{{$tarifa->nombre}}" {{isset($carrecs['director'][$tarifa->nombre_corto]) ? 'selected' : ''}} >{{$tarifa->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div> 
                        <div style="width:65%; float:left; margin-left:5%;">
                            <div id="tarifa_director1" style="display: {{ isset($carrecs['director']['rotllo']) ? '' : 'none;' }}">
                                <label for="tarifa_director1" style="font-weight: bold">Preu rotllo:</label>
                                <input type="number" class="form-control" id="tarifa_director1_inp" placeholder="Preu rotllo" name="preu_director_rotllo" value="{{ isset($carrecs['director']['rotllo']) ? $carrecs['director']['rotllo']['preu_carrec'] : ''}}" {{ isset($carrecs['director']['rotllo']) ? '' : 'disabled' }}>
                            </div>
                            <div id="tarifa_director2" style="display: {{ isset($carrecs['director']['minut']) ? '' : 'none;' }}">
                                <label for="tarifa_director2" style="font-weight: bold">Preu minut:</label>                                        
                                <input type="number" class="form-control" id="tarifa_director2_inp" placeholder="Preu minut" name="preu_director_minut" value="{{ isset($carrecs['director']['minut']) ? $carrecs['director']['minut']['preu_carrec'] : ''}}" {{ isset($carrecs['director']['minut']) ? '' : 'disabled' }}>
                            </div>
                        </div>       
                    </div>

                    
                </div>
                

                <div class="col-12" id="colTecnicSala" style="display:{{ isset($carrecs['tecnic_sala']) ? '' : 'none'}}">
                    
                    <div class="form-group" style="width:100%;">
                        <div style="width:30%; float:left">
                             <label for="tecnic_tarifas" style="font-weight: bold">Selección de tarifas tecnic:</label>
                             <select onchange="mostrarCamposTarifas(event,'tecnic')" id="tecnic_tarifas" multiple class="form-control">
                                 <option value="-1" disabled>Selecciona una tarifa</option>
                                 @foreach( $tarifas as $key => $tarifa)
                                     @if($tarifa->id_carrec == 3)
                                         <option value="{{$tarifa->nombre}}" {{isset($carrecs['tecnic_sala'][$tarifa->nombre_corto]) ? 'selected' : ''}}>{{$tarifa->nombre}}</option>
                                     @endif
                                 @endforeach
                             </select>
                         </div> 
                         <div style="width:65%; float:left; margin-left:5%;">
                             <div id="tarifa_tecnic1" style="display: {{ isset($carrecs['tecnic_sala']['sala']) ? '' : 'none;' }}">
                                 <label for="tarifa_tecnic1_inp" style="font-weight: bold">Tarifa sala:</label>
                                 <input type="number" class="form-control" id="tarifa_tecnic1_inp" placeholder="Tarifa sala" name="preu_tecnic_sala_sala" value="{{ isset($carrecs['tecnic_sala']['sala']) ? $carrecs['tecnic_sala']['sala']['preu_carrec'] : ''}}" {{ isset($carrecs['tecnic_sala']['sala']) ? '' : 'disabled' }}>
                             </div>
                             <div id="tarifa_tecnic2" style="display: {{ isset($carrecs['tecnic_sala']['mix']) ? '' : 'none;' }}">
                                 <label for="tarifa_tecnic2_inp" style="font-weight: bold">Tarifa mix:</label>                                        
                                 <input type="number" class="form-control" id="tarifa_tecnic2_inp" placeholder="Tarifa mix" name="preu_tecnic_sala_mix" value="{{ isset($carrecs['tecnic_sala']['mix']) ? $carrecs['tecnic_sala']['mix']['preu_carrec'] : ''}}" {{ isset($carrecs['tecnic_sala']['mix']) ? '' : 'disabled' }}>
                             </div>
                         </div>       
                     </div>
                </div>

            </div>
            <br>
            <!-- CARGOS: ACTOR, TRADUCTOR, AJUSTADOR, LINGÜISTA -->
            <div class="row container">
                <div id="colActor" style="width: 100%; margin-left: 15px; display:{{ isset($carrecs['actor']) ? '' : 'none'}}">
                    <div class="form-group">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr class="row">
                                    <th class="col">Actor</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $idiomes as $key => $idioma)
                                <tr class="row">
                                    <td class="col">
                                        <div class="form-group">
                                            <label for="idioma_actor_{{$idioma->idioma}}" style="font-weight: bold">{{$idioma->idioma}}:</label>
                                            <input type="checkbox" class="form-control" id="idioma_actor_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','actor', 1)" name="idioma_actor_{{$idioma->idioma}}" {{ isset($carrecs['actor'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                        </div>
                                    </td>
                                    <td class="col">
                                        <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Selección de tarifas:</label>
                                        <select onchange="mostrarCamposTarifas(event,'actor','{{$idioma->idioma}}')" id="{{$idioma->idioma}}_actor_tarifas" multiple class="form-control" {{ isset($carrecs['actor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="-1" disabled>Selecciona una tarifa</option>
                                            @foreach( $tarifas as $key => $tarifa)
                                                @if($tarifa->id_carrec == 1)
                                                    <option value="{{$tarifa->nombre}}" {{isset($carrecs['actor'][$idioma->idioma][$tarifa->nombre_corto]) ? 'selected' : ''}} > {{$tarifa->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="col">
                                        <div id="tarifa_actor1_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['video_take']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa video take:</label>
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_video_take" placeholder="Tarifa video take" name="preu_actor_{{$idioma->idioma}}_video_take" value="{{ isset($carrecs['actor'][$idioma->idioma]['video_take']) ? $carrecs['actor'][$idioma->idioma]['video_take']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['video_take']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor2_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['video_cg']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa video cg:</label>                                        
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_video_cg" placeholder="Tarifa video cg" name="preu_actor_{{$idioma->idioma}}_video_cg" value="{{ isset($carrecs['actor'][$idioma->idioma]['video_cg']) ? $carrecs['actor'][$idioma->idioma]['video_cg']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['video_cg']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor3_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['cine_take']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa cine take</label>                                        
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_cine_take" placeholder="Tarifa cine take" name="preu_actor_{{$idioma->idioma}}_cine_take" value="{{ isset($carrecs['actor'][$idioma->idioma]['cine_take']) ? $carrecs['actor'][$idioma->idioma]['cine_take']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['cine_take']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor4_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['cine_cg']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa cine cg:</label>                                        
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_cine_cg" placeholder="Tarifa cine cg" name="preu_actor_{{$idioma->idioma}}_cine_cg" value="{{ isset($carrecs['actor'][$idioma->idioma]['cine_cg']) ? $carrecs['actor'][$idioma->idioma]['cine_cg']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['cine_cg']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor5_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['canso']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa canso:</label>
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_canso" placeholder="Tarifa canso" name="preu_actor_{{$idioma->idioma}}_canso" value="{{ isset($carrecs['actor'][$idioma->idioma]['canso']) ? $carrecs['actor'][$idioma->idioma]['canso']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['canso']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor6_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['docu']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa docu:</label>
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_docu" placeholder="Tarifa docu" name="preu_actor_{{$idioma->idioma}}_docu" value="{{ isset($carrecs['actor'][$idioma->idioma]['docu']) ? $carrecs['actor'][$idioma->idioma]['docu']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['docu']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_actor7_{{$idioma->idioma}}" style="display: {{ isset($carrecs['actor'][$idioma->idioma]['narrador']) ? '' : 'none;' }}">
                                            <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa narrador:</label>
                                            <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}_narrador" placeholder="Tarifa narrador" name="preu_actor_{{$idioma->idioma}}_narrador" value="{{ isset($carrecs['actor'][$idioma->idioma]['narrador']) ? $carrecs['actor'][$idioma->idioma]['narrador']['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]['narrador']) ? '' : 'disabled' }}>
                                        </div>
                                    </td>
                                </tr>
                                    
                            @endforeach
                            </tbody> 
                        </table>
                    </div>
                </div>

                <div id="colTraductor" style="width: 100%; margin-left: 15px; display:{{ isset($carrecs['traductor']) ? '' : 'none'}}">
                    <div class="form-group">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr class="row">
                                    <th class="col">Traductor, Ajustador i Lingüista</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $idiomes as $key => $idioma)
                                <tr class="row">
                                    <td class="col">
                                        <div class="form-group">
                                            <label for="idioma_traductor_{{$idioma->idioma}}" style="font-weight: bold">{{$idioma->idioma}}:</label>
                                            <input type="checkbox" class="form-control" id="idioma_traductor_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','traductor', 0)" name="idioma_traductor_{{$idioma->idioma}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                        </div>
                                    </td>
                                    <td class="col">
                                        <label for="homologat_traductor_{{$idioma->idioma}}" style="font-weight: bold">Homologat:</label>
                                        <select class="form-control" id="homologat_traductor_{{$idioma->idioma}}" name="homologat_traductor_{{$idioma->idioma}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="0" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['empleat_homologat'] == false) ? 'selected' : ''}}>NO</option>
                                            <option value="1" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['empleat_homologat'] == true) ? 'selected' : ''}}>SI</option>
                                        </select>
                                        <label for="rotllo_traductor_{{$idioma->idioma}}" style="font-weight: bold">Rotllo:</label>
                                        <select class="form-control" id="rotllo_traductor_{{$idioma->idioma}}" name="rotllo_traductor_{{$idioma->idioma}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="0" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['rotllo'] == false) ? 'selected' : ''}}>NO</option>
                                            <option value="1" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['rotllo'] == true) ? 'selected' : ''}}>SI</option>
                                        </select>
                                    </td>
                                    <td class="col">
                                        <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Selección de tarifas:</label>
                                        <select onchange="mostrarCamposTarifas(event,'traductor','{{$idioma->idioma}}')" id="{{$idioma->idioma}}_traductor_tarifas" multiple class="form-control" {{ isset($carrecs['traductor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="-1" disabled>Selecciona una tarifa</option>
                                            @foreach( $tarifas as $key => $tarifa)
                                                @if($tarifa->id_carrec == 4)
                                                    <option value="{{$tarifa->nombre}}" {{isset($carrec_tarifa['traductor'][$idioma->idioma][$tarifa->nombre_corto]) ? 'selected' : ''}} > {{$tarifa->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="col">
                                        <div id="tarifa_traductor1_{{$idioma->idioma}}" style="display: {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['traductor']) ? '' : 'none;' }}">
                                            <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa traductor:</label>
                                            <input type="number" class="form-control" id="preu_traductor_{{$idioma->idioma}}_traductor" placeholder="Tarifa traductor" name="preu_traductor_{{$idioma->idioma}}_traductor" value="{{ isset($carrec_tarifa['traductor'][$idioma->idioma]['traductor']) ? $carrec_tarifa['traductor'][$idioma->idioma]['traductor']['preu_carrec'] : ''}}" {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['traductor']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_traductor2_{{$idioma->idioma}}" style="display: {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['ajustador']) ? '' : 'none;' }}">
                                            <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa ajustador:</label>
                                            <input type="number" class="form-control" id="preu_traductor_{{$idioma->idioma}}_ajustador" placeholder="Tarifa ajustador" name="preu_traductor_{{$idioma->idioma}}_ajustador" value="{{ isset($carrec_tarifa['traductor'][$idioma->idioma]['ajustador']) ? $carrec_tarifa['traductor'][$idioma->idioma]['ajustador']['preu_carrec'] : ''}}" {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['ajustador']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_traductor3_{{$idioma->idioma}}" style="display: {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['linguista']) ? '' : 'none;' }}">
                                            <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa lingüista:</label>                                        
                                            <input type="number" class="form-control" id="preu_traductor_{{$idioma->idioma}}_linguista" placeholder="Trifa lingüista" name="preu_traductor_{{$idioma->idioma}}_linguista" value="{{ isset($carrec_tarifa['traductor'][$idioma->idioma]['linguista']) ? $carrec_tarifa['traductor'][$idioma->idioma]['linguista']['preu_carrec'] : ''}}" {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['linguista']) ? '' : 'disabled' }}>
                                        </div>
                                        <div id="tarifa_traductor4_{{$idioma->idioma}}" style="display: {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['sinopsi']) ? '' : 'none;' }}">
                                            <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Tarifa sinopsi:</label>
                                            <input type="number" class="form-control" id="preu_traductor_{{$idioma->idioma}}_sinopsi" placeholder="Tarifa sinopsi" name="preu_traductor_{{$idioma->idioma}}_sinopsi" value="{{ isset($carrec_tarifa['traductor'][$idioma->idioma]['sinopsi']) ? $carrec_tarifa['traductor'][$idioma->idioma]['sinopsi']['preu_carrec'] : ''}}" {{ isset($carrec_tarifa['traductor'][$idioma->idioma]['sinopsi']) ? '' : 'disabled' }}>
                                        </div>
                                    </td>
                                </tr>          
                            @endforeach
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>

        <br>

        <!-- BOTÓN DE CREAR O ACTUALIZAR -->
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-success col-4">{{!empty($empleat) ? 'Desar canvis' : 'Crear'}}</button>
            </div>
        </div>
        <br>
    </form>
</div>

<script>

    function mostrarCamposTarifas(e,cargo,idioma){
        let valores = $('#'+e.target.id).val() // NO ACOSTUMBRARSE >:( JQUERY MEH
        let opciones = e.target.options;

        Array.prototype.forEach.call(opciones,function(element,key){
            var selected = false
            var val;
           
            valores.forEach(valor => {
                if(element.value == valor){
                    val = valor
                    selected = true  
                }
            });
            var lang = "";

            if(idioma && idioma.length > 0){
                lang = "_" + idioma
            }

            if (selected){
                switch(val){
                    case 'Tarifa video take':
                        document.getElementById('tarifa_'+ cargo + '1' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_video_take').removeAttribute('disabled')
                        break
                    case 'Tarifa video cg':
                        document.getElementById('tarifa_'+ cargo + '2' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo+ '_' + idioma + '_video_cg').removeAttribute('disabled')
                        break
                    case 'Tarifa cine take':
                        document.getElementById('tarifa_'+ cargo + '3' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_cine_take').removeAttribute('disabled')
                        break
                    case 'Tarifa cine cg':
                        document.getElementById('tarifa_'+ cargo + '4' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_cine_cg').removeAttribute('disabled')
                        break
                    case 'Tarifa canso':
                        document.getElementById('tarifa_'+ cargo + '5' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_canso').removeAttribute('disabled')
                        break
                    case 'Tarifa docu':
                        document.getElementById('tarifa_'+ cargo + '6' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_docu').removeAttribute('disabled')
                        break
                    case 'Tarifa narrador':
                        document.getElementById('tarifa_'+ cargo + '7' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_narrador').removeAttribute('disabled')
                        break
                    case 'Preu rotllo':
                    case 'Tarifa sala':
                        document.getElementById('tarifa_'+ cargo + '1').style.display = ''
                        document.getElementById('tarifa_'+ cargo + '1').removeAttribute('disabled')
                        document.getElementById('tarifa_'+ cargo + '1_inp').style.display = ''
                        document.getElementById('tarifa_'+ cargo + '1_inp').removeAttribute('disabled')
                        break
                    case 'Preu minut':
                    case 'Tarifa mix':
                        document.getElementById('tarifa_'+ cargo + '2').style.display = ''
                        document.getElementById('tarifa_'+ cargo + '2').removeAttribute('disabled')
                        document.getElementById('tarifa_'+ cargo + '2_inp').style.display = ''
                        document.getElementById('tarifa_'+ cargo + '2_inp').removeAttribute('disabled')
                        break
                    case 'Tarifa traductor':
                        document.getElementById('tarifa_'+ cargo + '1' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_traductor').removeAttribute('disabled')
                        break
                    case 'Tarifa ajustador':
                        document.getElementById('tarifa_'+ cargo + '2' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_ajustador').removeAttribute('disabled')
                        break
                    case 'Tarifa lingüista':
                        document.getElementById('tarifa_'+ cargo + '3' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_linguista').removeAttribute('disabled')
                        break
                    case 'Tarifa sinopsi':
                        document.getElementById('tarifa_'+ cargo + '4' + lang).style.display = ''
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_sinopsi').removeAttribute('disabled')
                        break
                }
            } else {
                switch(element.value){//preu_actor_{{$idioma->idioma}}_video_take
                    case 'Tarifa video take':
                        document.getElementById('tarifa_'+ cargo + '1' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_video_take').setAttribute('disabled' , '')
                        break
                    case 'Tarifa video cg':
                        document.getElementById('tarifa_'+ cargo + '2' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo+ '_' + idioma + '_video_cg').setAttribute('disabled' , '')
                        break
                    case 'Tarifa cine take':
                        document.getElementById('tarifa_'+ cargo + '3' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_cine_take').setAttribute('disabled' , '')
                        break
                    case 'Tarifa cine cg':
                        document.getElementById('tarifa_'+ cargo + '4' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_cine_cg').setAttribute('disabled' , '')
                        break
                    case 'Tarifa canso':
                        document.getElementById('tarifa_'+ cargo + '5' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_canso').setAttribute('disabled' , '')
                        break
                    case 'Tarifa docu':
                        document.getElementById('tarifa_'+ cargo + '6' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_docu').setAttribute('disabled' , '')
                        break
                    case 'Tarifa narrador':
                        document.getElementById('tarifa_'+ cargo + '7' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_narrador').setAttribute('disabled' , '')
                        break
                    case 'Preu rotllo':
                    case 'Tarifa sala':
                        document.getElementById('tarifa_'+ cargo + '1').style.display = 'none'
                        document.getElementById('tarifa_'+ cargo + '1').setAttribute('disabled' , '')
                        document.getElementById('tarifa_'+ cargo + '1_inp').setAttribute('disabled' , '')
                        break
                    case 'Preu minut':
                    case 'Tarifa mix':
                        document.getElementById('tarifa_'+ cargo + '2').style.display = 'none'
                        document.getElementById('tarifa_'+ cargo + '2').setAttribute('disabled' , '')
                        document.getElementById('tarifa_'+ cargo + '2_inp').setAttribute('disabled' , '')
                        break
                    case 'Tarifa traductor':
                        document.getElementById('tarifa_'+ cargo + '1' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_traductor').setAttribute('disabled' , '')
                        break
                    case 'Tarifa ajustador':
                        document.getElementById('tarifa_'+ cargo + '2' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_ajustador').setAttribute('disabled' , '')
                        break
                    case 'Tarifa lingüista':
                        document.getElementById('tarifa_'+ cargo + '3' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_linguista').setAttribute('disabled' , '')
                        break
                    case 'Tarifa sinopsi':
                        document.getElementById('tarifa_'+ cargo + '4' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_sinopsi').setAttribute('disabled' , '')
                        break
                    case 'Tarifa traductor':
                        document.getElementById('tarifa_'+ cargo + '1' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_traductor').setAttribute('disabled' , '')
                        break
                    case 'Tarifa ajustador':
                        document.getElementById('tarifa_'+ cargo + '2' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_ajustador').setAttribute('disabled' , '')
                        break
                    case 'Tarifa lingüista':
                        document.getElementById('tarifa_'+ cargo + '3' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_linguista').setAttribute('disabled' , '')
                        break
                    case 'Tarifa sinopsi':
                        document.getElementById('tarifa_'+ cargo + '4' + lang).style.display = 'none'
                        document.getElementById('preu_'+ cargo + '_' + idioma + '_sinopsi').setAttribute('disabled' , '')
                        break
                }
            }
        });
        
    }

    function mostrarCamps(valor) {
     
        switch(valor){
            case "actor":
                        if (colActor.style.display == 'none') {
                            colActor.style.display = 'block';
                            localStorage.setItem('colActor', 'block');
                        } else {
                            colActor.style.display = 'none';
                        }
            break;
            case "director":
                        if (colDirector.style.display == 'none') {
                            colDirector.style.display = 'block';
                        } else {
                            colDirector.style.display = 'none';
                        }
            break;
            case "tecnic":
                        if (colTecnicSala.style.display == 'none') {
                            colTecnicSala.style.display = 'block';
                        } else {
                            colTecnicSala.style.display = 'none';
                        }
            break;
            case "traductor":
                        if (colTraductor.style.display == 'none') {
                            colTraductor.style.display = 'block';
                        } else {
                            colTraductor.style.display = 'none';
                        }
            break;
        }
        
    }

    function mostrarSubMenus(idioma, carrec, type){

        function clearSelected(elemento){
            var elements = elemento.options;

            for(var i = 0; i < elements.length; i++){
                elements[i].selected = false;
            }
        }

        if (document.getElementById("idioma_"+carrec+"_"+idioma).checked == true ) {
            
            if (type == 1){
                document.getElementById(idioma+'_'+carrec+'_tarifas').removeAttribute('disabled');
            } else {
                document.getElementById("homologat_"+carrec+"_"+idioma).removeAttribute('disabled');
                document.getElementById(idioma+'_'+carrec+'_tarifas').removeAttribute('disabled');
                document.getElementById("rotllo_"+carrec+"_"+idioma).removeAttribute('disabled');
            }
        }else{
            
            if (type == 1){
                document.getElementById(idioma+'_'+carrec+'_tarifas').setAttribute('disabled',"");
            } else {
                document.getElementById("homologat_"+carrec+"_"+idioma).setAttribute('disabled',"");
                document.getElementById(idioma+'_'+carrec+'_tarifas').setAttribute('disabled',"");    
                document.getElementById("rotllo_"+carrec+"_"+idioma).setAttribute('disabled',"");
            }
            clearSelected(document.getElementById(idioma+'_'+carrec+'_tarifas'))
        }

    }

</script>
@endsection
