var empleatPerEsborrar = 0;
//--------Funcions per la ventanes modals-----------
function setEmpleatPerEsborrar(empleatId, empleatAlias) {
    empleatPerEsborrar = empleatId;
    if (empleatAlias != undefined) {
        document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'empleat <b>' + empleatAlias + '</b>?';
    }
}

function deleteEmpleat() {
    if (empleatPerEsborrar != 0) {
        document.all["delete-" + empleatPerEsborrar].submit();
    }
}

//--------Funcions per el filtra-----------
function selectSearch() {
    if ($('#searchBy').children(":selected").attr("id") == 'carrec') {
        $('#search_term').remove();

        var select = document.createElement("select");
        $(select).attr("name", "search_term");
        $(select).attr("id", "search_term");
        $(select).attr("class", "form-control");

        $.each(carrecs, function( key, carrec ) {
            $(select).append('<option value="'+carrec['id_carrec']+'">'+carrec['descripcio_carrec'].toUpperCase()+'</option>');
        });

        $(select).insertAfter('#searchBy');
    } else if ($('#searchBy').children(":selected").attr("id") == 'sexe'){
        $('#search_term').remove();

        var select = document.createElement("select");
        $(select).attr("name", "search_term");
        $(select).attr("id", "search_term");
        $(select).attr("class", "form-control");
        $(select).append('<option value="Dona">DONA</option>');
        $(select).append('<option value="Home">HOME</option>');

        $(select).insertAfter('#searchBy');
    } else {
        $('#search_term').remove();
        $('<input type="text" class="form-control" id="search_term" name="search_term" placeholder="Buscar treballador...">').insertAfter('#searchBy');
    }
}

$('#searchBy').change(selectSearch);  