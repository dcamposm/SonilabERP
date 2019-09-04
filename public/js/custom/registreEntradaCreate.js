//--------Funcions per treure els camp de EPISODIS TOTALS, EPISODIS SETMANALS I ENTREGUES SETMANALS-----------
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

//----------------Funcions per validar els camps----------------
$('input').keyup(validarInput);
$('select').change(validarSelect);
$('#sortida').change(validarDate);

function validarInput(){
    console.log($(this).attr('id'));
    if ($(this).attr('type') == 'number') {
        var pattern = /^\d*$/;
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if (pattern.test($(this).val())){
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        }
    } else if ($(this).attr('type') == 'text'){
        var pattern = /^\w*$/;
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if (pattern.test($(this).val())){
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        }
    }
}

function validarSelect(){
    if ($(this).children(":selected").val() == ''){
        removeValid(this);
    } else {
        $(this).addClass("is-valid");
    }
}

function validarDate(){
    if ($(this).val() == ''){
        removeValid(this);
    } else {
        $(this).addClass("is-valid");
    }
}

function removeValid(input){
    $(input).removeClass("is-valid");
    $(input).removeClass("is-invalid");
}