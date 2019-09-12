$('input').keyup(validarInput);

function validarInput(){
    if ($(this).attr('id') == 'takesIni'){
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            var dia = $(this).parents("div").find('[diaIni]').attr('diaIni');
            var sala = $(this).parents("div").find('[numSala]').attr('numSala');
            var hora = $(this).val();
            
            var check = data.filter( function(e) {
                var horaIni = e.data_inici.split(' ')[1]
                var horaFi= e.data_fi.split(' ')[1]
                var diaIni = e.data_inici.split(' ')[0]
      
                if (horaIni <= hora && hora < horaFi && diaIni == dia && e.calendari.num_sala == sala){
                    return e;
                }
            });

            if (check == "" && hora >= "08:30"){
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
                
                checkTakesAfegir()
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        }
    } else if ($(this).attr('id') == 'takesIni-editar'){
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            var dia = $(this).parents("div").find('[diaSelec]').attr('diaSelec');
            var sala = $(this).parents("div").find('[numSalaSelec]').attr('numSalaSelec');
            var hora = $(this).val();
            
            var check = data.filter( function(e) {
                var horaIni = e.data_inici.split(' ')[1]
                var horaFi= e.data_fi.split(' ')[1]
                var diaIni = e.data_inici.split(' ')[0]
      
                if (horaIni <= hora && hora < horaFi && diaIni == dia && e.calendari.num_sala == sala){
                    return e;
                }
            });

            if (check == "" && hora >= "08:30"){
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        }
    } else if ($(this).attr('id') == 'takesFin-editar'){
        if ($(this).val() == ''){
            removeValid(this);
        } else {
            var dia = $(this).parents("div").find('[diaSelec]').attr('diaSelec');
            var sala = $(this).parents("div").find('[numSalaSelec]').attr('numSalaSelec');
            var hora = $(this).val();
            
            var check = data.filter( function(e) {
                var horaIni = e.data_inici.split(' ')[1]
                var horaFi= e.data_fi.split(' ')[1]
                var diaIni = e.data_inici.split(' ')[0]
                if (horaIni > $('#takesIni-editar').val()) {
                    if (horaIni < hora &&  diaIni == dia && e.calendari.num_sala == sala){
                        return e;
                    }
                }
            });

            if (check == "" && hora > $('#takesIni-editar').val()){
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        }
    }
}


function checkTakesEditar(){
    var dia = $('#formEditar').parents("div").find('[diaSelec]').attr('diaSelec');
    var sala = $('#formEditar').parents("div").find('[numSalaSelec]').attr('numSalaSelec');

    if ($('#takesIni-editar').val() <= "13:30") var torn = 0;
    else var torn = 1;

    var perce = 0;

    $.each(data, function( key, element ) { 
        if (element.calendari.torn == torn && element.data_inici.split(' ')[0] ==  dia && element.calendari.num_sala == sala) {
            if (element.id_registre_entrada != $('#registreEntrada-editar').val() || element.setmana != $('#setmana-editar').val() || element.id_actor != $('#actor-editar').val()){
                perce += element.num_takes;
            }
        }
    });
    perce += parseInt($('#numberTakes-editar').val());

    if (perce > 100){
        removeValid($('#numberTakes-editar'));
        $('#numberTakes-editar').addClass("is-invalid");
        $('#errorEditar').removeAttr('hidden');
        $('#errorEditar').text('Els takes superen la capacitat.');
    } else {
        removeValid($('#numberTakes-editar'));
        $('#numberTakes-editar').addClass("is-valid");
    }
}

function checkTakesAfegir(){
    var dia = $('#formAfegir').parents("div").find('[diaini]').attr('diaini');
    var sala = $('#formAfegir').parents("div").find('[numsala]').attr('numsala');

    if ($('#takesIni').val() <= "13:30") var torn = 0;
    else var torn = 1;

    var perce = 0;

    $.each(data, function( key, element ) { 
        if (element.calendari.torn == torn && element.data_inici.split(' ')[0] ==  dia && element.calendari.num_sala == sala) {
            if (element.id_registre_entrada != $('#registreEntrada').val() || element.setmana != $('#setmana').val() || element.id_actor != $('#actor').val()){
                perce += element.num_takes;
            }
        }
    });
    
    perce += parseInt($('#numberTakes').val());

    if (perce > 100){
        removeValid($('#numberTakes'));
        $('#numberTakes').addClass("is-invalid");
        $('#errorAfegir').removeAttr('hidden');
        $('#errorAfegir').text('Els takes superen la capacitat.');
    } else {
        removeValid($('#numberTakes'));
        $('#numberTakes').addClass("is-valid");
    } 
}

function removeValid(input){
    $(input).removeClass("is-valid");
    $(input).removeClass("is-invalid");
}

$('#formEditar').find('button').click(function(e) {
    e.preventDefault();
    
    checkTakesEditar();
    
    var invalid = $('#formEditar').find(".is-invalid");

    if (invalid.length !== 0) {
        return;
    }
    
    switch ($(this).attr('id')) {
        case 'botoAfegir':
            afegirActor();
            return;
        case 'botoEditar':
            editarActor();
            return;
        case 'botoEliminar':
            eliminarCalendarioActor();
            return;
    }
});

$('#formEditar').submit(function(e) {
    e.preventDefault();
});


$('#btnGuardar').click(function(e) {
    e.preventDefault();
    
    checkTakesAfegir();
    
    var invalid = $('#formAfegir').find(".is-invalid");

    if (invalid.length !== 0) {
        return;
    }
    
    guardarCelda();
});