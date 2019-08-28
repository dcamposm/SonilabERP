var usuariPerEsborrar = 0;

//Funcions per les ventenes modals
self.mostrarUsuari = function (urlShow) {
    window.location.replace(urlShow);
}

function setUsuariPerEsborrar(userId, userAlias) {
    usuariPerEsborrar = userId;
    if (userAlias != undefined) {
        document.getElementById('delete-message').innerHTML = 'Vols esborrar l\'usuari <b>' + userAlias + '</b>?';
    }
}

function deleteUsuari() {
    if (usuariPerEsborrar != 0) {
        document.all["delete-" + usuariPerEsborrar].submit();
    }
}

$('#searchBy').change(selectSearch);
//--------Funcions per el buscador-----------
function selectSearch() {
    if ($('#searchBy').children(":selected").attr("id") == 'departament') {
        $('#search_term').remove();

        var select = document.createElement("select");
        $(select).attr("name", "search_term");
        $(select).attr("id", "search_term");
        $(select).attr("class", "form-control");

        $.each(departaments, function( key, departament ) {
            $(select).append('<option value="'+departament['id_departament']+'">'+departament['nom_departament'].toUpperCase()+'</option>');
        });

        $(select).insertAfter('#searchBy');
    } else {
        $('#search_term').remove();
        $('<input type="text" class="form-control" id="search_term" name="search_term" placeholder="BUSCAR USUARI...">').insertAfter('#searchBy');
    }
}

$("#table").tablesorter({
    theme : "bootstrap",
    
    headerTemplate: '{content} {icon}'
});
