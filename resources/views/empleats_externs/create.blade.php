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
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="email_empleat" style="font-weight: bold">Email:</label>
                        <input type="email" class="form-control" id="email_empleat" placeholder="Entrar correu" name="email_empleat" value="{{!empty($empleat) ? $empleat->email_empleat : ''}}">
                    </div> 
                </div>
                
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="cognom1_empleat" style="font-weight: bold">Primer Cognom:</label>
                        <input type="text" class="form-control" id="cognom1_empleat" placeholder="Entrar primer cognom" name="cognom1_empleat" value="{{!empty($empleat) ? $empleat->cognom1_empleat : ''}}">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="cognom2_empleat" style="font-weight: bold">Segon Cognom:</label>
                        <input type="text" class="form-control" id="cognom2_empleat" placeholder="Entrar segon cognom" name="cognom2_empleat" value="{{!empty($empleat) ? $empleat->cognom2_empleat : ''}}">
                    </div>
                </div>
            </div>
            <!-- POR AQUI IMAGEN -->
            <div class="row">
                <!-- <div class="col-6">
                    <div class="form-group">
                        <label for="imatge_empleat" style="font-weight: bold">Alias:</label>
                        <input type="text" class="form-control" id="alias_usuari" placeholder="Entrar alias" name="alias_usuari" value="{{!empty($empleat) ? $empleat->alias_empleat : ''}}">
                    </div>
                </div> -->
                <div class="col-6">
                    <div class="form-group">
                        <label for="sexe_empleat" style="font-weight: bold">Sexe:</label>
                        <select class="form-control" name="sexe_empleat">
                            <option value="Dona" {{(!empty($empleat) && $empleat->sexe_empleat == 'Dona') ? 'selected' : ''}}>Dona</option>
                            <option value="Home" {{(!empty($empleat) && $empleat->sexe_empleat == 'Home') ? 'selected' : ''}}>Home</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nacionalitat" style="font-weight: bold">Nacionalitat:</label>
                        <input type="text" class="form-control" id="nacionalitat_empleat" placeholder="Entrar nacionalitat" name="nacionalitat_empleat" value="{{!empty($empleat) ? $empleat->nacionalitat_empleat : ''}}">
                    </div>
                </div>
                

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="dni_empleat" style="font-weight: bold">DNI:</label>
                        <input type="text" class="form-control" id="dni_empleat" placeholder="Entrar DNI empleat" name="dni_empleat" value="{{!empty($empleat) ? $empleat->dni_empleat : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="telefon_empleat" style="font-weight: bold">Telèfon:</label>
                        <input type="tel" class="form-control" id="telefon_empleat" placeholder="Entrar telèfon empleat" name="telefon_empleat" value="{{!empty($empleat) ? $empleat->telefon_empleat : ''}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="direccio_empleat" style="font-weight: bold">Direcció:</label>
                        <input type="text" class="form-control" id="direccio_empleat" placeholder="Entrar direcció empleat" name="direccio_empleat" value="{{!empty($empleat) ? $empleat->direccio_empleat : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="codi_postal_empleat" style="font-weight: bold">Codi postal:</label>
                        <input type="number" class="form-control" id="codi_postal_empleat" placeholder="Entrar codi postal empleat" name="codi_postal_empleat" value="{{!empty($empleat) ? $empleat->codi_postal_empleat : ''}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="naixement_empleat" style="font-weight: bold">Data naixement:</label>
                        <input type="date" max="{{$fecha16AnyosMenos}}" value="{{$fecha16AnyosMenos}}" class="form-control" id="naixement_empleat" placeholder="Entrar data naixement empleat" name="naixement_empleat" value="{{!empty($empleat) ? explode(' ',$empleat->naixement_empleat)[0] : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="nss_empleat" style="font-weight: bold">NSS:</label>
                        <input type="text" class="form-control" id="nss_empleat" placeholder="Entrar número seguretat social empleat" name="nss_empleat" value="{{!empty($empleat) ? $empleat->nss_empleat : ''}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="iban_empleat" style="font-weight: bold">IBAN:</label>
                        <input type="text" class="form-control" id="iban_empleat" placeholder="Entrar IBAN empleat" name="iban_empleat" value="{{!empty($empleat) ? $empleat->iban_empleat : ''}}">
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="border p-2">
            <legend class="w-auto">Càrrecs:</legend>

            <!-- CHECKBOX PARA ACTIVAR CARGOS -->
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="director" style="font-weight: bold">Director:</label>
                        <input type="checkbox" onchange="mostrarCamps('director')" class="form-control" id="director" name="director" {{ isset($carrecs['director']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="tecnic_sala" style="font-weight: bold">Tècnic:</label>
                        <input type="checkbox" onchange="mostrarCamps('tecnic')" class="form-control" id="tecnic_sala" name="tecnic_sala" {{ isset($carrecs['tecnic_sala']) ? 'checked' : ''}} value="1">
                    </div>
                </div>               
                <div class="col-2">
                    <div class="form-group">
                        <label for="actor" style="font-weight: bold">Actor:</label>
                        <input type="checkbox" onchange="mostrarCamps('actor')" class="form-control" id="actor" name="actor" {{ isset($carrecs['actor']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="traductor" style="font-weight: bold">Traductor:</label>
                        <input type="checkbox" onchange="mostrarCamps('traductor')" class="form-control" id="traductor" name="traductor" {{ isset($carrecs['traductor']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="ajustador" style="font-weight: bold">Ajustador:</label>
                        <input type="checkbox" onchange="mostrarCamps('ajustador')" class="form-control" id="ajustador" name="ajustador" {{ isset($carrecs['ajustador']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="linguista" style="font-weight: bold">Lingüista:</label>
                        <input type="checkbox" onchange="mostrarCamps('linguista')" class="form-control" id="linguista" name="linguista" {{ isset($carrecs['linguista']) ? 'checked' : ''}} value="1">
                    </div>
                </div>
            </div>

            <!-- CARGOS: DIRECTOR, TÉCNICO DE SALA -->
            <div class="row">
                
                
                <div class="col-4" id="colDirector" style="display:{{ isset($carrecs['director']) ? '' : 'none'}}">

                    <div class="form-group">
                        <label for="preu_rotllo_director" style="font-weight: bold">Preu rotllo:</label>
                        <input type="number" class="form-control" id="preu_rotllo_director" placeholder="Entrar preu rotllo" name="preu_rotllo_director" value="{{ isset($carrecs['director']) ? $carrecs['director']['preu_carrec'] : ''}}" {{ isset($carrecs['director']) ? '' : 'disabled' }}>
                    </div>
                    
                    <div class="form-group">
                        <label for="preu_minut_director" style="font-weight: bold">Preu rotllo:</label>
                        <input type="number" class="form-control" id="preu_director" placeholder="Entrar preu rotllo" name="preu_director" value="{{ isset($carrecs['director']) ? $carrecs['director']['preu_carrec'] : ''}}" {{ isset($carrecs['director']) ? '' : 'disabled' }}>
                    </div> 

                </div>
                

                <div class="col-4" id="colTecnicSala" style="display:{{ isset($carrecs['tecnic_sala']) ? '' : 'none'}}">
                    <div class="form-group">
                        <label for="preu_tecnicSala" style="font-weight: bold">Preu tècnic de sala:</label>
                        <input type="number" class="form-control" id="preu_tecnicSala" placeholder="Entrar preu tècnic de Sala" name="preu_tecnic_sala" value="{{ isset($carrecs['tecnic_sala']) ? $carrecs['tecnic_sala']['preu_carrec'] : ''}}" {{ isset($carrecs['tecnic_sala']) ? '' : 'disabled' }}>
                    </div>
                </div>

            </div>

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
                                            <input type="checkbox" class="form-control" id="idioma_actor_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','actor')" name="idioma_actor_{{$idioma->idioma}}" {{ isset($carrecs['actor'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                        </div>
                                    </td>
                                    <td class="col">
                                        <label for="homologat_actor_{{$idioma->idioma}}" style="font-weight: bold">Homologat:</label>
                                        <select class="form-control" id="homologat_actor_{{$idioma->idioma}}" name="homologat_actor_{{$idioma->idioma}}" {{ isset($carrecs['actor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="0" {{ (isset($carrecs['actor'][$idioma->idioma]) && $carrecs['actor'][$idioma->idioma]['empleat_homologat'] == false) ? 'selected' : ''}}>NO</option>
                                            <option value="1" {{ (isset($carrecs['actor'][$idioma->idioma]) && $carrecs['actor'][$idioma->idioma]['empleat_homologat'] == true) ? 'selected' : ''}}>SI</option>
                                        </select>
                                    </td>
                                    <td class="col">
                                    <label for="preu_actor_{{$idioma->idioma}}" style="font-weight: bold">Preu actor:</label>
                                        <input type="number" class="form-control" id="preu_actor_{{$idioma->idioma}}" placeholder="Entrar preu actor" name="preu_actor_{{$idioma->idioma}}" value="{{ isset($carrecs['actor'][$idioma->idioma]) ? $carrecs['actor'][$idioma->idioma]['preu_carrec'] : ''}}" {{ isset($carrecs['actor'][$idioma->idioma]) ? '' : 'disabled' }}>
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
                                    <th class="col">Traductor</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $idiomes as $key => $idioma)
                                <tr class="row">
                                    <td class="col">
                                        <div class="form-group">
                                            <label for="idioma_traductor_{{$idioma->idioma}}" style="font-weight: bold">{{$idioma->idioma}}:</label>
                                            <input type="checkbox" class="form-control" id="idioma_traductor_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','traductor')" name="idioma_traductor_{{$idioma->idioma}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                        </div>
                                    </td>
                                    <td class="col">
                                        <label for="homologat_traductor_{{$idioma->idioma}}" style="font-weight: bold">Homologat:</label>
                                        <select class="form-control" id="homologat_traductor_{{$idioma->idioma}}" name="homologat_traductor_{{$idioma->idioma}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="0" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['empleat_homologat'] == false) ? 'selected' : ''}}>NO</option>
                                            <option value="1" {{ (isset($carrecs['traductor'][$idioma->idioma]) && $carrecs['traductor'][$idioma->idioma]['empleat_homologat'] == true) ? 'selected' : ''}}>SI</option>
                                        </select>
                                    </td>
                                    <td class="col">
                                    <label for="preu_traductor_{{$idioma->idioma}}" style="font-weight: bold">Preu traductor:</label>
                                        <input type="number" class="form-control" id="preu_traductor_{{$idioma->idioma}}" placeholder="Entrar preu traductor" name="preu_traductor_{{$idioma->idioma}}" value="{{ isset($carrecs['traductor'][$idioma->idioma]) ? $carrecs['traductor'][$idioma->idioma]['preu_carrec'] : ''}}" {{ isset($carrecs['traductor'][$idioma->idioma]) ? '' : 'disabled' }}>
                                    </td>
                                </tr>          
                            @endforeach
                            </tbody> 
                        </table>
                    </div>
                </div>
                <div id="colAjustador" style="width: 100%; margin-left: 15px; display:{{ isset($carrecs['ajustador']) ? '' : 'none'}}">
                        <div class="form-group">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr class="row">
                                        <th class="col">Ajustador</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach( $idiomes as $key => $idioma)
                                    <tr class="row">
                                        <td class="col">
                                            <div class="form-group">
                                                <label for="idioma_ajustador_{{$idioma->idioma}}" style="font-weight: bold">{{$idioma->idioma}}:</label>
                                                <input type="checkbox" class="form-control" id="idioma_ajustador_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','ajustador')" name="idioma_ajustador_{{$idioma->idioma}}" {{ isset($carrecs['ajustador'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                            </div>
                                        </td>
                                        <td class="col">
                                            <label for="homologat_ajustador_{{$idioma->idioma}}" style="font-weight: bold">Homologat:</label>
                                            <select class="form-control" id="homologat_ajustador_{{$idioma->idioma}}" name="homologat_ajustador_{{$idioma->idioma}}" {{ isset($carrecs['ajustador'][$idioma->idioma]) ? '' : 'disabled' }}>
                                                <option value="0" {{ (isset($carrecs['ajustador'][$idioma->idioma]) && $carrecs['ajustador'][$idioma->idioma]['empleat_homologat'] == false) ? 'selected' : ''}}>NO</option>
                                                <option value="1" {{ (isset($carrecs['ajustador'][$idioma->idioma]) && $carrecs['ajustador'][$idioma->idioma]['empleat_homologat'] == true) ? 'selected' : ''}}>SI</option>
                                            </select>
                                        </td>
                                        <td class="col">
                                        <label for="preu_ajustador_{{$idioma->idioma}}" style="font-weight: bold">Preu ajustador:</label>
                                            <input type="number" class="form-control" id="preu_ajustador_{{$idioma->idioma}}" placeholder="Entrar preu ajustador" name="preu_ajustador_{{$idioma->idioma}}" value="{{ isset($carrecs['ajustador'][$idioma->idioma]) ? $carrecs['ajustador'][$idioma->idioma]['preu_carrec'] : ''}}" {{ isset($carrecs['ajustador'][$idioma->idioma]) ? '' : 'disabled' }}>
                                        </td>
                                    </tr>          
                                @endforeach
                                </tbody> 
                            </table>
                        </div>
                    </div>
                <div id="colLinguista" style="width: 100%; margin-left: 15px; display:{{ isset($carrecs['linguista']) ? '' : 'none'}}">
                    <div class="form-group">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr class="row">
                                    <th class="col">Lingüista</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $idiomes as $key => $idioma)
                                <tr class="row">
                                    <td class="col">
                                        <div class="form-group">
                                            <label for="idioma_linguista_{{$idioma->idioma}}" style="font-weight: bold">{{$idioma->idioma}}:</label>
                                            <input type="checkbox" class="form-control" id="idioma_linguista_{{$idioma->idioma}}" onchange="mostrarSubMenus('{{$idioma->idioma}}','linguista')" name="idioma_linguista_{{$idioma->idioma}}" {{ isset($carrecs['linguista'][$idioma->idioma]) ? 'checked': '' }} value="1">
                                        </div>
                                    </td>
                                    <td class="col">
                                        <label for="homologat_linguista_{{$idioma->idioma}}" style="font-weight: bold">Homologat:</label>
                                        <select class="form-control" id="homologat_linguista_{{$idioma->idioma}}" name="homologat_linguista_{{$idioma->idioma}}" {{ isset($carrecs['linguista'][$idioma->idioma]) ? '' : 'disabled' }}>
                                            <option value="0" {{ (isset($carrecs['linguista'][$idioma->idioma]) && $carrecs['linguista'][$idioma->idioma]['empleat_homologat'] == false) ? 'selected' : ''}}>NO</option>
                                            <option value="1" {{ (isset($carrecs['linguista'][$idioma->idioma]) && $carrecs['linguista'][$idioma->idioma]['empleat_homologat'] == true) ? 'selected' : ''}}>SI</option>
                                        </select>
                                    </td>
                                    <td class="col">
                                    <label for="preu_linguista_{{$idioma->idioma}}" style="font-weight: bold">Preu lingüista:</label>
                                        <input type="number" class="form-control" id="preu_linguista_{{$idioma->idioma}}" placeholder="Entrar preu lingüista" name="preu_linguista_{{$idioma->idioma}}" value="{{ isset($carrecs['linguista'][$idioma->idioma]) ? $carrecs['linguista'][$idioma->idioma]['preu_carrec'] : ''}}" {{ isset($carrecs['linguista'][$idioma->idioma]) ? '' : 'disabled' }}>
                                    </td>
                                </tr>          
                            @endforeach
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="row">
            <div class="form-group">
                <label for="imatge_empleat" style="font-weight: bold">Imatge Empleat:</label>
                <input type="file" name="imatge_empleat" />
            </div>
        </div>
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
    
    function onReady(){
        //console.log(localStorage)
    }

    function mostrarCamps(valor) {
     
        switch(valor){
            case "actor":
                        if (colActor.style.display == 'none') {
                            colActor.style.display = 'block';
                            localStorage.setItem('colActor', 'block')
                        } else {
                            colActor.style.display = 'none';
                        }
            break;
            case "director":
                        if (colDirector.style.display == 'none') {
                            colDirector.style.display = 'block';
                            preu_director.removeAttribute("disabled"); 
                        } else {
                            colDirector.style.display = 'none';
                            preu_director.setAttribute("disabled", ""); 
                        }
            break;
            case "tecnic":
                        if (colTecnicSala.style.display == 'none') {
                            colTecnicSala.style.display = 'block';
                            preu_tecnicSala.removeAttribute("disabled"); 
                        } else {
                            colTecnicSala.style.display = 'none';
                            preu_tecnicSala.setAttribute("disabled", ""); 
                        }
            break;
            case "traductor":
                        if (colTraductor.style.display == 'none') {
                            colTraductor.style.display = 'block';
                        } else {
                            colTraductor.style.display = 'none';
                        }
            break;
            case "ajustador":
                        if (colAjustador.style.display == 'none') {
                            colAjustador.style.display = 'block';
                        } else {
                            colAjustador.style.display = 'none';
                        }
            break;
            case "linguista":
                        if (colLinguista.style.display == 'none') {
                            colLinguista.style.display = 'block';
                        } else {
                            colLinguista.style.display = 'none';
                        }
            break;
        }
        
    }

    function mostrarSubMenus(idioma,carrec){
        
        switch(idioma){
            case "Català":
                        if (document.getElementById("idioma_"+carrec+"_Català").checked == true ) {
                            document.getElementById("homologat_"+carrec+"_Català").removeAttribute('disabled');
                            document.getElementById("preu_"+carrec+"_Català").removeAttribute('disabled');
                        }else{
                            document.getElementById("homologat_"+carrec+"_Català").setAttribute('disabled',"");
                            document.getElementById("preu_"+carrec+"_Català").setAttribute('disabled',"");
                        }
            break;
            case "Castellà":
                        if (document.getElementById("idioma_"+carrec+"_Castellà").checked == true ) {
                            document.getElementById("homologat_"+carrec+"_Castellà").removeAttribute('disabled');
                            document.getElementById("preu_"+carrec+"_Castellà").removeAttribute('disabled');
                        }else{
                            document.getElementById("homologat_"+carrec+"_Castellà").setAttribute('disabled',"");
                            document.getElementById("preu_"+carrec+"_Castellà").setAttribute('disabled',"");
                        }
            break;
            case "Anglès":
                        if (document.getElementById("idioma_"+carrec+"_Anglès").checked == true ) {
                            document.getElementById("homologat_"+carrec+"_Anglès").removeAttribute('disabled');
                            document.getElementById("preu_"+carrec+"_Anglès").removeAttribute('disabled',"");
                        }else{
                            document.getElementById("homologat_"+carrec+"_Anglès").setAttribute('disabled',"");
                            document.getElementById("preu_"+carrec+"_Anglès").setAttribute('disabled',"");
                        }
            break;
          
        }
    }

    onReady()

</script>
@endsection
