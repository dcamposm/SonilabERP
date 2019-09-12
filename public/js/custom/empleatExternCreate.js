function mostrarCamps(valor) {
    switch(valor){
        case "actor":
                    if (colActor.style.display == 'none') {
                        colActor.style.display = 'block';
                        localStorage.setItem('colActor', 'block');
                    } else {
                        colActor.style.display = 'none';
                    }
        break;
        case "director":
                    if (colDirector.style.display == 'none') {
                        colDirector.style.display = 'block';
                    } else {
                        colDirector.style.display = 'none';
                    }
        break;
        case "tecnic":
                    if (colTecnicSala.style.display == 'none') {
                        colTecnicSala.style.display = 'block';
                    } else {
                        colTecnicSala.style.display = 'none';
                    }
        break;
        case "traductor":
                    if (colTraductor.style.display == 'none') {
                        colTraductor.style.display = 'block';
                    } else {
                        colTraductor.style.display = 'none';
                    }
        break;
    }

}

function mostrarSubMenus(idioma, carrec, type){

    function clearSelected(elemento){
        var elements = elemento.options;

        for(var i = 0; i < elements.length; i++){
            elements[i].selected = false;
        }
    }

    if (document.getElementById("idioma_"+carrec+"_"+idioma).checked == true ) {

        if (type == 1){
            //tarifes_actors
            document.getElementById('tarifes_'+ carrec + '_' + idioma).style.display = '';
        } else {
            if (idioma == 'Català') {
                document.getElementById("homologat_"+carrec+"_"+idioma).removeAttribute('disabled');
            }
            document.getElementById('tarifes_'+ carrec + '_' + idioma).style.display = '';
        }
    }else{

        if (type == 1){
            document.getElementById('tarifes_'+ carrec + '_' + idioma).style.display = 'none'
        } else {
            if (idioma == 'Català') {
                document.getElementById("homologat_"+carrec+"_"+idioma).setAttribute('disabled',"");
            }
            document.getElementById('tarifes_'+ carrec + '_' + idioma).style.display = 'none'   
        }

    }

}

//Funcions per validar els camps
$('input').keyup(validarInput);
$('select').change(validarSelect);
$('#naixement_empleat').change(validarDate);

function validarInput(){
    //CODI POSTAL
    if ($(this).attr('id') == 'codi_postal_empleat'){
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
    } 
    //DNI
    else if ($(this).attr('id') == 'dni_empleat'){
        var pattern = /[0-9A-Z][0-9]{7}[A-Z]/;
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if (pattern.test($(this).val())){
                checkUnique($(this).attr('id'), $(this).val());
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).next().text('');
            }
        } 
    } 
    //IBAN
    /*else if ($(this).attr('id') == 'iban_empleat'){
        var pattern = /^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/;
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
        
    }*/
    //EMAIL
    else if ($(this).attr('id') == 'email_empleat'){
        var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if (pattern.test($(this).val())){
                checkUnique($(this).attr('id'), $(this).val());
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).next().text('');
            }
        }
    } 
    //TELEFON
    else if ($(this).attr('id') == 'telefon_empleat'){
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
    } 
    //NSS
    else if ($(this).attr('id') == 'nss_empleat'){
        var pattern = /^\d*$/;
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            if (pattern.test($(this).val())){
                checkUnique($(this).attr('id'), $(this).val());
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $(this).next().text('');
            }
        }
    }
    //DIRECCIO
    else if ($(this).attr('id') == 'direccio_empleat') {
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            $(this).addClass("is-valid");            
        }
    } 
    //NUMBERS
    else if ($(this).attr('type') == 'number') {
        var pattern = /^([0-9]+)([.]?)[0-9]{0,2}$/;
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
    //TEXT
    else if ($(this).attr('type') == 'text'){
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
    if ($(this).children(":selected").val() == ''){
        removeValid(this);
    } else {
        $(this).addClass("is-valid");
    }
}

function validarDate(){
    console.log($(this).attr('id'));
    if ($(this).val() == ''){
        removeValid(this);
    } else {
        $(this).addClass("is-valid");
    }
}

function removeValid(input){
    $(input).removeClass("is-valid");
    $(input).removeClass("is-invalid");
    $(input).next().text('');
}

function checkUnique(camp, value){
    $.ajax({
        url: '/empleats/check',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            camp: camp,
            value: value,
        },
        success: function (response) {
            if (response == true){
                $('#'+camp).removeClass("is-valid");
                $('#'+camp).addClass("is-invalid");
                $('#'+camp).next().text('Aquesta dada ja existeix.');
            } else {
                $('#'+camp).removeClass("is-invalid");
                $('#'+camp).addClass("is-valid");
                $('#'+camp).next().text('');
            }
        },
        error: function (error) {
            console.error(error);
            alert("Error al comprovar una dada");
        }
    });
}