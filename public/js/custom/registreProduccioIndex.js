
    var self = this;
    self.registrePerEsborrar = 0;

    // Executa el formulari per mostrar la vista d'un registre d'entrada.
    self.mostrarRegistreProduccio = function (urlShow) {
        window.location.replace(urlShow);
    }

    // Emmagatzema l'identificador d'un registre d'entrada i mostra un missatge en el modal d'esborrar.
    self.seleccionarRegistreProduccio = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            document.getElementById('delete-message').innerHTML = 'Vols esborrar el registre de producció <b>' + registreProduccioAlias + '</b>?';
        }
    }
    
    self.seleccionarEstadillo = function (registreProduccioId, registreProduccioAlias) {
        self.registrePerEsborrar = registreProduccioId;
        if (registreProduccioAlias != undefined) {
            $('#id_estadillo').attr('value', registreProduccioId);
            document.getElementById('message').innerHTML = 'Importar estadillo de <b>' + registreProduccioAlias + '</b>:';
        }
    }
    // Esborra el registre d'entrada seleccionat.
    self.deleteRegistre = function () {
        if (self.registrePerEsborrar != 0) {
            document.all["delete-" + self.registrePerEsborrar].submit(); 
        }
    }

//--------Funcions per el filtra-----------
    function selectSearch() {
    //var value = $('#searchBy').val();

    //alert($('#searchBy').children(":selected").attr("id")); //Com obtenir el id del option
    if ($('#searchBy').children(":selected").attr("id") == 'estat') {
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="Pendent">PENDENT</option><option value="Finalitzada">FINALITZAT</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'date'){
        $('#search_term').remove();
        $('<input type="date" class="form-control" id="search_term" name="search_term">').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'fet'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="0">NO FET</option><option value="1">FET</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'inserts'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="No cal fer">NO CAL FER</option><option value="Cal fer">CAL FER</option><option value="Fet">FET</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'retakes'){
        $('#search_term').remove();
        $('<select class="custom-select" id="search_term" name="search_term" form="search"><option value="No">NO</option><option value="Si">SI</option><option value="Fet">FET</option></select>').insertAfter('#orderBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'responsable'){
        $('#search_term').remove();
        
        var select = document.createElement("select");
        $(select).attr("name", "search_term");
        $(select).attr("id", "search_term");
        $(select).attr("class", "form-control");
        
        $.each(usuaris, function( key, usuari ) {
            $(select).append('<option value="'+usuari['id_usuari']+'">'+usuari['alias_usuari'].toUpperCase()+'</option>');
        });
        
        $(select).insertAfter('#orderBy');
    }
    else {
        //Canviem el input actual per el que necessitem
        $('#search_term').remove();
        $('<input type="text" id="search_term" class="form-control" name="search_term" placeholder="Buscar per...">').insertAfter('#orderBy');
    }
    }

    $('#searchBy').change(selectSearch);