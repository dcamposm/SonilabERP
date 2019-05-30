//--------Funcions per les ventanes modals-----------
var self = this;
self.registrePerEsborrar = 0;

// Executa el formulari per mostrar la vista d'un registre d'entrada.
self.mostrarRegistreEntrada = function (urlShow) {
    window.location.replace(urlShow);
}

// Emmagatzema l'identificador d'un registre d'entrada i mostra un missatge en el modal d'esborrar.
self.seleccionarRegistreEntrada = function (registreEntradaId, registreEntradaAlias) {
    self.registrePerEsborrar = registreEntradaId;
    if (registreEntradaAlias != undefined) {
        document.getElementById('delete-message').innerHTML = 'Vols esborrar el registre d\'entrada <b>' + registreEntradaAlias + '</b>?';
    }
}

// Esborra el registre d'entrada seleccionat.
self.esborrarRegistreEntrada = function () {
    if (self.registrePerEsborrar != 0) {
        document.all["delete-" + self.registrePerEsborrar].submit(); 
    }
}

//--------Funcions per el buscador-----------
function selectSearch() {
    //var value = $('#searchBy').val();

    //alert(value);
    if ($('#searchBy').children(":selected").attr("id") == 'select') {
        $('#search_term').remove();

        var select = document.createElement("select");
        $(select).attr("name", "search_term");
        $(select).attr("id", "search_term");
        $(select).attr("class", "form-control");

        if ($('#searchBy').val() == 'estat'){
            $(select).append('<option value="Pendent">Pendent</option>');
            $(select).append('<option value="Finalitzada">Finalitzada</option>');
            $(select).append('<option value="Cancel·lada">Cancel·lada</option>');
        } else if ($('#searchBy').val() == 'id_usuari'){
            $.each(usuaris, function( key, usuari ) {
                $(select).append('<option value="'+usuari['id_usuari']+'">'+usuari['alias_usuari'].toUpperCase()+'</option>');
            });
        } else if ($('#searchBy').val() == 'id_client'){
            $.each(clients, function( key, client ) {
                $(select).append('<option value="'+client['id_client']+'">'+client['nom_client'].toUpperCase()+'</option>');
            });
        } else if ($('#searchBy').val() == 'id_servei'){
            $.each(serveis, function( key, servei ) {
                $(select).append('<option value="'+servei['id_servei']+'">'+servei['nom_servei'].toUpperCase()+'</option>');
            });
        } else if ($('#searchBy').val() == 'id_idioma'){
            $.each(idiomes, function( key, idioma ) {
                $(select).append('<option value="'+idioma['id_idioma']+'">'+idioma['idioma'].toUpperCase()+'</option>');
            });
        } else if ($('#searchBy').val() == 'id_media'){                
            $.each(medies, function( key, media ) {
                $(select).append('<option value="'+media['id_media']+'">'+media['nom_media'].toUpperCase()+'</option>');
            });
        }

        $(select).insertAfter('#orderBy');
    } else {
        if ($('#searchBy').val() == 'sortida') {
            $('#search_term').remove();
            $('<input type="date" class="form-control" id="search_term" name="search_term">').insertAfter('#orderBy');
        } else if ($('#searchBy').val() == 'minuts'){
            $('#search_term').remove();
            $('<input type="number" class="form-control" id="search_term" name="search_term">').insertAfter('#orderBy');
        } 
        else {
            $('#search_term').remove();
            $('<input type="text" class="form-control" id="search_term" name="search_term">').insertAfter('#orderBy');
        }
    }
}

$('#searchBy').change(selectSearch); 