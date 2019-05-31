//----------------Funcions per validar els camps----------------
$('input').keyup(validarInput);
$('select').change(validarSelect);

function validarInput(){
    console.log($(this).attr('id'));
    if ($(this).attr('id') == 'telefon_client'){
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
    } else if ($(this).attr('id') == 'email_client'){
        var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
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
    } else if ($(this).attr('id') == 'codi_postal_client'){
        var pattern = /^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/;
        
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
    } else if ($(this).attr('id') == 'nif_client') {
        var pattern = /[0-9A-Z][0-9]{7}[A-Z]/;
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
    } else if ($(this).attr('id') == 'direccio_client') {
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            $(this).addClass("is-valid");            
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
    //console.log($(this).children(":selected").val());
    if ($(this).children(":selected").val() == ''){
        removeValid(this);
    } else {
        $(this).addClass("is-valid");
    }
}

function removeValid(input){
    //console.log(input);
    $(input).removeClass("is-valid");
    $(input).removeClass("is-invalid");
}