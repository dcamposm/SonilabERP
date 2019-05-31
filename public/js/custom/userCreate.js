//Funcions per validar els camps
$('input').keyup(validarInput);
$('select').change(validarSelect);

function validarInput(){
    console.log($(this).attr('id'));
    if ($(this).attr('id') == 'contrasenya_usuari' || $(this).attr('id') == 'cpass'){
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if ($('#contrasenya_usuari').val() === $('#cpass').val()){
                $('#contrasenya_usuari').removeClass("is-invalid");
                $('#cpass').removeClass("is-invalid");
                $('#contrasenya_usuari').addClass("is-valid");
                $('#cpass').addClass("is-valid");
            } else {
                $('#contrasenya_usuari').removeClass("is-valid");
                $('#cpass').removeClass("is-valid");
                $('#contrasenya_usuari').addClass("is-invalid");
                $('#cpass').addClass("is-invalid");
            }
        }
    } else if ($(this).attr('id') == 'email_usuari'){
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
    } else if ($(this).attr('type') == 'text'){
        var pattern = /^\D*$/;
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