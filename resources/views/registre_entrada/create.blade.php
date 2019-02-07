@extends('layouts.app')

@section('content')

<?php

use Carbon\Carbon;

$fecha16AnyosMenos = Carbon::now()->subYears(16)->format('Y-m-d');
?>

<div class="container">
    <h2 style="font-weight: bold">{{!empty($registreEntrada) ? 'Editar registre Entrada' : 'Crear registre Entrada'}}</h2>
    <form method = "POST" action="#" enctype="multipart/form-data">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Dades:</legend>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="titol" style="font-weight: bold">Titol:</label>
                        <input type="text" class="form-control" id="nom_empleat" placeholder="Entrar titol" name="titol" value="{{!empty($registreEntrada) ? $registreEntrada->titol : ''}}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="entrada" style="font-weight: bold">Data Entrada:</label>
                        <input type="date" class="form-control" id="entrada" placeholder="Entrar data Entrada" name="entrada" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->entrada)[0] : ''}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="sortida" style="font-weight: bold">Data Sortida:</label>
                        <input type="date" class="form-control" id="entrada" placeholder="Entrar data Sortida" name="sortida" value="{{!empty($registreEntrada) ? explode(' ',$registreEntrada->sortida)[0] : ''}}">
                    </div>
                </div>

                <div class="col-6">
                    <label for="client" style="font-weight: bold">Selecciona client existent:</label>
                    <select class="form-control" name="id_client">
                        @foreach( $clients as $client )
                        <option value="{{$client['id_client']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $client['id_client']) ? 'selected' : ''}} >{{$client['nom_client']}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            
            <div class="row">
                <div class="col-6">
                    <label for="client" style="font-weight: bold">Selecciona servei:</label>
                    <select class="form-control" name="id_servei">
                        @foreach( $serveis as $servei )
                        <option value="{{$servei['id_servei']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $client['id_servei']) ? 'selected' : ''}} >{{$servei['nom_servei']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="idioma" style="font-weight: bold">Selecciona idioma:</label>
                    <select class="form-control" name="id_idioma">
                        @foreach( $idiomes as $idioma )
                        <option value="{{$servei['id_idioma']}}" {{(!empty($registreEntrada) && $registreEntrada->id_registre_entrada == $idioma['id_idioma']) ? 'selected' : ''}} >{{$idioma['idioma']}}</option>
                        @endforeach
                    </select>
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

    function mostrarCamposTarifas(e, cargo, idioma){
    let valores = $('#' + e.target.id).val() // NO ACOSTUMBRARSE >:( JQUERY MEH
            let opciones = e.target.options;
    console.log(valores)
            Array.prototype.forEach.call(opciones, function(element, key){
            var selected = false
                    var val;
            valores.forEach(valor = > {
            if (element.value == valor){
            val = valor
                    selected = true
            }
            });
            var lang = "";
            if (idioma && idioma.length > 0){
            lang = "_" + idioma
            }

            if (selected){
            switch (val){
            case 'Tarifa video take':
                    document.getElementById('tarifa_' + cargo + '1' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '1' + lang).removeAttribute('disabled')
                    break
                    case 'Tarifa video cg':
                    document.getElementById('tarifa_' + cargo + '2' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '2' + lang).removeAttribute('disabled')
                    break
                    case 'Tarifa cine take':
                    document.getElementById('tarifa_' + cargo + '3' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '3' + lang).removeAttribute('disabled')
                    break
                    case 'Tarifa cine cg':
                    document.getElementById('tarifa_' + cargo + '4' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '4' + lang).removeAttribute('disabled')
                    break
                    case 'Tarifa canso':
                    document.getElementById('tarifa_' + cargo + '5' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '5' + lang).removeAttribute('disabled')
                    break
                    case 'Preu rotllo':
                    document.getElementById('tarifa_' + cargo + '1' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '1' + lang).removeAttribute('disabled')
                    break
                    case 'Preu minut':
                    document.getElementById('tarifa_' + cargo + '2' + lang).style.display = ''
                    document.getElementById('tarifa_' + cargo + '2' + lang).removeAttribute('disabled')
                    break
            }
            } else {
            switch (element.value){
            case 'Tarifa video take':
                    document.getElementById('tarifa_' + cargo + '1' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '1' + lang).setAttribute('disabled', '')
                    break
                    case 'Tarifa video cg':
                    document.getElementById('tarifa_' + cargo + '2' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '2' + lang).setAttribute('disabled', '')
                    break
                    case 'Tarifa cine take':
                    document.getElementById('tarifa_' + cargo + '3' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '3' + lang).setAttribute('disabled', '')
                    break
                    case 'Tarifa cine cg':
                    document.getElementById('tarifa_' + cargo + '4' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '4' + lang).setAttribute('disabled', '')
                    break
                    case 'Tarifa canso':
                    document.getElementById('tarifa_' + cargo + '5' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '5' + lang).setAttribute('disabled', '')
                    break
                    case 'Preu rotllo':
                    document.getElementById('tarifa_' + cargo + '1' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '1' + lang).setAttribute('disabled', '')
                    break
                    case 'Preu minut':
                    document.getElementById('tarifa_' + cargo + '2' + lang).style.display = 'none'
                    document.getElementById('tarifa_' + cargo + '2' + lang).setAttribute('disabled', '')
                    break

            }
            }
            });
    }

    function mostrarCamps(valor) {

    switch (valor){
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
    colDirector.removeAttribute("disabled");
    } else {
    colDirector.style.display = 'none';
    colDirector.setAttribute("disabled", "");
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

    function mostrarSubMenus(idioma, carrec, type){

    function clearSelected(elemento){
    var elements = elemento.options;
    for (var i = 0; i < elements.length; i++){
    elements[i].selected = false;
    }
    }

    if (document.getElementById("idioma_" + carrec + "_" + idioma).checked == true) {
    document.getElementById("homologat_" + carrec + "_" + idioma).removeAttribute('disabled');
    if (type == 1){
    document.getElementById(idioma + '_' + carrec + '_tarifas').removeAttribute('disabled');
    } else {
    document.getElementById('preu_' + carrec + '_' + idioma).removeAttribute('disabled');
    }
    } else{
    document.getElementById("homologat_" + carrec + "_" + idioma).setAttribute('disabled', "");
    if (type == 1){
    document.getElementById(idioma + '_' + carrec + '_tarifas').setAttribute('disabled', "");
    } else {
    document.getElementById('preu_' + carrec + '_' + idioma).setAttribute('disabled', "");
    }
    clearSelected(document.getElementById(idioma + '_' + carrec + '_tarifas'))
    }

    }

</script>
@endsection
