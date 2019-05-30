//--------Funcions per el filtra-----------
    $( document ).ready(function() {
        if ($('#id_media').val() < '5' && $('#id_media').val() > 1) {
            $('#total_ep').hide();
            $('#ep_set').hide();
            $('#ent_set').hide();
        }
        else {
            $('#total_ep').show();
            $('#ep_set').show();
            $('#ent_set').show();
        }
    });
    function hideInputs() {
        //var value = $('#id_media').val();
        
        //alert(value);
        if ($('#id_media').val() < '5' && $('#id_media').val() > 1) {
            $('#total_ep').hide();
            $('#ep_set').hide();
            $('#ent_set').hide();
        }
        else {
            $('#total_ep').show();
            $('#ep_set').show();
            $('#ent_set').show();
        }
    }
    
    $('#id_media').change(hideInputs); 