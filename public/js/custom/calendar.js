/////  INIT  /////
$('#semanaMenos').on('click', function () {
    changeCalendar(0);
});
$('#semanaMas').on('click', function () {
    changeCalendar(1);
});

$('.alternar').on('click', function () {
    $('#calendarContent').html('');
    if (getCookie("tablaActual")==0){
        document.cookie = "tablaActual = 1";
    } else {
        document.cookie = "tablaActual = 0";
    }
    carregarCalendari(); 
});

$('#btnGuardar').click(guardarCelda);

$('#btnFesta').click(setFesta);

carregarCalendari();

function carregarCalendari(){
    crearTablaCalendario();
    tablaHoras();
    cargarDatos(); 
    creatPasarLlista();
}

function resetCalendari(){
    $('#calendarContent').html('');
    carregarCalendari();
    
    tablaHoras();
    pintarTablaHoras();
}

var persona = undefined;
var takesPosibles = undefined;

//INPUTS EASY-AUTOCOMPLETE
var optionsActor = {
    url:  rutaSearchEmpleat+"?search=Actor",
    placeholder: "Filtrar per actor",
    getValue: "nom_cognom",
    
    list: {
            match: {
                enabled: true
            }, onChooseEvent: function() {
                var selectedPost = $("#searchActor").getSelectedItemData();
                $("#filtroActor").attr("value", selectedPost.id_empleat);
                $("#searchActor").val(selectedPost.nom_cognom).trigger("change");
                filtrar()
            }, onHideListEvent: function() {
                if ($("#searchActor").val() == ''){
                    $("#filtroActor").val('-1');
                    filtrar() 
                }
            }
    },
    
    template: {
            type: "custom",
            method: function(value, item) {
                    return value;
            }
    },
};

$("#searchActor").easyAutocomplete(optionsActor);

var optionsRegistre = {
    url:  rutaSearchEntrada,
    placeholder: "Filtrar per registre d'entrada",
    getValue: "referencia_titol",

    list: {
            match: {
                enabled: true
            }, onChooseEvent: function() {
                var selectedPost = $("#searchEntrada").getSelectedItemData();
                $("#filtroEntrada").attr("value", selectedPost.id_registre_entrada);
                $("#searchEntrada").val(selectedPost.id_registre_entrada+" "+selectedPost.titol).trigger("change");
                filtrar();
            }, onHideListEvent: function() {
                if ($("#searchEntrada").val() == ''){
                    $("#filtroEntrada").val('-1');
                    filtrar(); 
                }
            }
    },

    template: {
            type: "custom",
            method: function(value, item) {
                    return value;
            }
    },
};

$("#searchEntrada").easyAutocomplete(optionsRegistre);

actoresSave = actores;
var optionsActorSide = {
    url:  rutaSearchEmpleat+"?search=Actor",
    placeholder: "Filtrar actor",
    getValue: "nom_cognom",
    
    list: {
            match: {
                enabled: true
            }, onChooseEvent: function() {
                var selectedPost = $("#searchActorSide").getSelectedItemData();
                
                actores = actoresSave.filter(item => item.id_actor == selectedPost.id_empleat);
                cargarActores();
            }, onHideListEvent: function() {
                if ($("#searchActorSide").val() == ''){
                    actores = actoresSave;
                    cargarActores();
                }
            }
    },
    
    template: {
            type: "custom",
            method: function(value, item) {
                    return value;
            }
    },
};

$("#searchActorSide").easyAutocomplete(optionsActorSide);

function crearTablaCalendario() {
    if (getCookie("tablaActual")==0 || getCookie("tablaActual")===""){
        document.cookie = "tablaActual = 0";
        var contenedor = $('#calendarContent');
        
        for (let i = 0; i < 8; i++) {
            var fila = $('<div class="row fila"  style="min-width: 2000px;"></div>');
            var sala = i + 1;
            // Crea un div con el número de la sala:
            fila.append('<div class="sala celda">' + sala + '</div>');
            for (let h = 0; h < 5; h++) {
                    // Crea el día de la sala.
                    // Es necesario crear el atributo "dia" y "sala", para que después cuando le hagamos clic
                    // podamos coger el día y la sala de la casilla que hayamos seleccionado.
                    fila.append('<div class="col celda" dia="' + dias[h] + '" sala="' + sala + '">\n\
                                    <div class="row rowMati">\n\
                                        <div class="progress barra_progreso">\n\
                                            <div class="progress-bar barra progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">\n\
                                                0%\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="row rowTarda">\n\
                                        <div class="progress barra_progreso">\n\
                                            <div class="progress-bar barra progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">\n\
                                                0%\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>'
                    );
            }
            contenedor.append(fila);
        }
    } else {
        document.cookie = "tablaActual = 1";
        var contenedor = $('#calendarContent');
        for (let i = 0; i < 8; i++) {
            var fila = $('<div class="row fila"  style="min-width: 2000px;"></div>');
            var sala = i + 1;
            // Crea un div con el número de la sala:
            fila.append('<div class="sala celda">' + sala + '</div>');
            for (let h = 0; h < 5; h++) {
                d = dias[h];
                s = sala;

                var tecnicMati = tecnicsAsignados.filter(filtroTecnicSalaM);
                var tecnicTarda = tecnicsAsignados.filter(filtroTecnicSalaT);
                    // Crea el día de la sala.
                    // Es necesario crear el atributo "dia" y "sala", para que después cuando le hagamos clic
                    // podamos coger el día y la sala de la casilla que hayamos seleccionado.
                    fila.append('<div class="col celda" dia="' + dias[h] + '" sala="' + sala + '" style=" min-height: 200px;">\n\
                                    <div class="row rowMati">\n\
                                        <div class="col colGlob">\n\
                                            <div class="row det">\n\
                                                <div class="viewTecnic" style="'+ (!tecnicMati[0]  ? '' : (!tecnicMati[0].empleat ? 'border-left: 1px solid black;' : 'background-color: '+tecnicMati[0].empleat.color_empleat+'; border-left: 1px solid black;')) +'">'+ (!tecnicMati[0] ? '' : (!tecnicMati[0].empleat ? '' : tecnicMati[0].empleat.nom_empleat)) +'</div>\n\
                                                <div class="col mati"></div>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                    <div class="row rowTarda">\n\
                                        <div class="col colGlob">\n\
                                            <div class="row det">\n\
                                                <div class="viewTecnic" style="'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? 'border-left: 1px solid black;' : 'background-color: '+tecnicTarda[0].empleat.color_empleat+'; border-left: 1px solid black;')) +'">'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? '' : tecnicTarda[0].empleat.nom_empleat) ) +'</div>\n\
                                                <div class="col tarda"></div>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>'
                    );
            }
            contenedor.append(fila);
        }
    }
    
    $('.celda').attr('ondrop', 'drop(event)');
    $('.celda').attr('ondragover', 'allowDrop(event)');
}

function filtroTecnicSalaM(e) {
    if (e.data == d && e.num_sala == s && e.torn == 0){
        return e;
    }
}
function filtroTecnicSalaT(e) {
    if (e.data == d && e.num_sala == s && e.torn == 1){
        return e;
    }
}

function cargarDatos() {
    if (getCookie("tablaActual")==0){
        $.each(data, function( key, element ) {   
            if (element.data_inici.split(' ')[1] <= '13:30') {
                var celda = $("[dia=" + element.data_inici.split(' ')[0] + "][sala=" + element.calendari.num_sala + "]")[0].children[0].children[0];
            } else {
                var celda = $("[dia=" + element.data_inici.split(' ')[0] + "][sala=" + element.calendari.num_sala + "]")[0].children[1].children[0];
            }
            
            var perce = Number(celda.innerText.replace('%', '')) + ((element.num_takes)*100)/200;
            celda.innerText = perce + '%';
            celda.style.width = perce + '%';
            celda.setAttribute('aria-valuenow', perce);
            cambiarColorCelda(celda, perce);
        });
    } else {     
        $.each(data, function( key, element ) {   
            if (element.data_inici.split(' ')[1] <= '13:30') {
                var actorSala = '<div class="row '+(element.asistencia === 0 ? 'actorNoPres' : '')+'">\
                                    <div class="col-1 llistaActors" style="padding-left: 5px; padding-right: 0px;">'+element.data_inici.split(' ')[1]+'</div>\n\
                                    <div class="col-4 llistaActors" style="padding-left: 5px; padding-right: 0px;">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                    <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                    <div class="col-4 llistaActors" style="padding-left: 5px; padding-right: 5px; '+(!element.registre_entrada  ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                    <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
                                </div>';
                $("[dia=" + element.data_inici.split(' ')[0] + "][sala=" + element.calendari.num_sala + "]").children().children().children().children('.mati').append(actorSala);
            } else {
                var actorSala = '<div class="row '+(element.asistencia === 0 ? 'actorNoPres' : '')+'">\n\
                                    <div class="col-1 llistaActors" style="padding-left: 5px; padding-right: 0px;">'+element.data_inici.split(' ')[1]+'</div>\n\
                                    <div class="col-4 llistaActors" style="padding-left: 5px; padding-right: 0px;">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                    <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                    <div class="col-4 llistaActors" style="padding-left: 5px; padding-right: 5px; '+(!element.registre_entrada  ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                    <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
                                </div>';
                $("[dia=" + element.data_inici.split(' ')[0] + "][sala=" + element.calendari.num_sala + "]").children().children().children().children('.tarda').append(actorSala);
            }
        });
    }

    cargarActores();
    $('.celda').click(ampliarCasilla);
}

function cargarActores() {
    var trabajadores = {};

    $.each(actores, function( key, element ) {
        if (trabajadores[element.id_actor]){
            trabajadores[element.id_actor].takes_restantes = trabajadores[element.id_actor].takes_restantes + element.takes_restantes;
        } else {
            trabajadores[element.id_actor] = {id_actor: element.id_actor, nombre_actor: element.empleat.nom_cognom, takes_restantes: element.takes_restantes};
        }
    });

    $('#trabajadores').html('');
    for (const key in trabajadores) {
        if (trabajadores[key].takes_restantes > 0){
            $('#trabajadores').append('<li id=' + trabajadores[key].id_actor + ' draggable="true" ondragstart="drag(event)">' + trabajadores[key].nombre_actor + '</li>');
        }
    }
}

function actulitzarActors(){
    $.ajax({
        url: '/calendari/postActors',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
        },
        success: function (response) {
            actores = response;
            cargarActores();
        },
        error: function (error) {
            console.error(error);
            alert("Error Actualitzar Actors");
        }
    });
}

function actulitzarDades(){
    $.ajax({
        url: '/calendari/postDades',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            week: week,
            year: year
        },
        success: function (response) {
            data = response;
            resetCalendari();
        },
        error: function (error) {
            console.error(error);
            alert("Error Actualitzar Dades");
        }
    });
}

function filtrar(){
    var idActor = $('#filtroActor').val();
    var idProyecto = $('#filtroEntrada').val();

    if (idActor != -1 && idProyecto != -1){
        data = dataBase.filter(item => item.id_actor == idActor);
        data = dataBase.filter(item => item.id_registre_entrada == idProyecto);
    } else if (idActor != -1){
        data = dataBase.filter(item => item.id_actor == idActor);
    } else if (idProyecto != -1){
        data = dataBase.filter(item => item.id_registre_entrada == idProyecto);
    } else {
        data = dataBase;
    }

    refrescarCalendarioFiltrado();
    cargarDatos();
}

///// FUNCTIONS /////

function refrescarCalendarioFiltrado(){
    $('#calendarContent').html('');
    crearTablaCalendario();
}

function guardarCelda() {
    if (getCookie("tablaActual")==0){
        var data_inici = celda.parentElement.parentElement.getAttribute("dia") + " " + $('#takesIni').val() + ":00";
        //var data_fi = celda.parentElement.parentElement.getAttribute("dia") + " " + $('#takesFin').val() + ":00";
        var num_sala = celda.parentElement.parentElement.getAttribute("sala");
    } else {
        var data_inici = celda.getAttribute("dia") + " " + $('#takesIni').val() + ":00";
        //var data_fi = celda.getAttribute("dia") + " " + $('#takesFin').val() + ":00";
        var num_sala = celda.getAttribute("sala"); 
    }
    
    var actor= $('#actor').val();  
    var registreEntrada= $('#registreEntrada').val(); 
    var setmana= $('#setmana').val(); 
    var opcio_calendar = $('#opcio_calendar').val();
    let takes = Number($('#numberTakes').val());

    /** Comprobación errores inputs modal **/
    var errores = false;
    if ($("#takesIni")[0].checkValidity() == false) {
        errores = true;
    }
    /*if ($("#takesFin")[0].checkValidity() == false){
        errores = true;
    } */
    if ($("#numberTakes")[0].checkValidity() == false) {
        errores = true;
    }
    /*if (takesPosibles < takes){
        $("#numberTakes")[0].setCustomValidity('');
        errores = true;
    }*/
        
    //let color = $("#color").val() == '#ffffff' ? null :$("#color").val();
    
    if (errores) return
    var datos = {id_actor: actor, 
                id_registre_entrada: registreEntrada, 
                setmana: setmana, 
                num_takes: takes, 
                data_inici: data_inici, 
                num_sala: num_sala, 
                opcio_calendar: opcio_calendar};
    $.post('/calendari/crear', datos)
        .done(function (datosCalendari) {
            if (getCookie("tablaActual")==0){
                let valorActual = Number($(celda).attr('aria-valuenow'))
                let takesSuma = ((takes*100)/200) + valorActual;
                if (takes && takes > 0) {
                    $(celda).attr('aria-valuenow', takesSuma);
                    $(celda).text(takesSuma + '%');
                    $(celda).css({ 'width': takesSuma + '%' });
                    
                    if (takesSuma < 25) {
                        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-success';
                    } else if (takesSuma < 50) {
                        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-info';
                    } else if (takesSuma < 75) {
                        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-warning';
                    } else if (takesSuma <= 100) {
                        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-danger';
                    }
                }
            }

            $.each(actores, function( key, element ) {
                if (element.id_actor == $('#actor').val() && element.id_registre_entrada == $('#registreEntrada').val() && element.setmana == $('#setmana').val()) {
                    element.takes_restantes = element.takes_restantes-takes;
                }                
            });
            cargarActores();
            actulitzarDades();
        })
        .fail(function (error) {
            console.error(error);
        });

    $('#exampleModal').modal('hide');
}

//setFesta

function setFesta(){
    var datos = {diaInici: $("#diaInici").val(), 
                diaFi: $("#diaFi").val(), 
                descripcio_festiu: $("#descripcio_festiu").val()};
    $.post('/calendari/crear', datos)
        .done(function (datosCalendari) {
            
            cargarActores();
            actulitzarDades();
        })
        .fail(function (error) {
            console.error(error);
        });
        
    $('#modalConf').modal('hide');
}

function creatPasarLlista(){
    $.ajax({
        url: '/calendari/actorsPerDia',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            fechas: dias
        },
        success: function (response) {
            $('#pasarLista-tabla').html('');
            $.each(response, function( key, dia ) {
                $.each(dia, function( key2, actor ) {
                    var tr = $('<tr id="' + actor.id_calendar + '-' + actor.id_actor_estadillo + '-' + actor.num_sala + '" class="dia-' + actor.dia + '-' + actor.num_sala+ ' lista-actores"></tr>');
                    var td1 = $('<td id="actor_mod-' + actor.id_calendar + '" onclick="seleccionarActorCalendario(this.id, this)" class="col-8"></td>');
                    if (actor.id_director == 0){
                        var td1Value = '<span class="horaActor">(' + actor.hora+':'+actor.minuts + ') </span><span id="content_actor">' + actor.nom_cognom + '</span>';
                        td1.append($(td1Value));
                    } else {  
                        $.each(directors, function( key3, director ) {
                            if (actor.id_director == director.id_empleat){
                                var td1Value = '<span class="horaActor">(' + actor.hora+':'+actor.minuts + ') </span><span id="content_actor">' + actor.nom_cognom + ' - ' + director.nom_cognom + '</span>';
                                td1.append($(td1Value));
                            }
                        });
                       
                    }
                    
                    tr.append(td1);
                    
                    var td2Value = 
                    '<td>' + 
                        '<div class="btn-group btn-group-toggle" data-toggle="buttons">' + 
                            '<label class="btn btn-success '+(actor.asistencia == 1 ? 'active' : '')+'">' +
                                '<input type="radio" name="actor-' + actor.id_empleat + '-' + actor.id_calendar + '" id="actor-' + actor.id_empleat + '" class="actor-dia-' + pad(actor.dia) + '-' + actor.num_sala + '" autocomplete="off" value="1" '+(actor.asistencia == 1 ? 'checked' : '')+'> Present' +
                            '</label>' +
                            '<label class="btn btn-danger '+(actor.asistencia === 0 ? 'active' : '')+'">' +
                                '<input type="radio" name="actor-' + actor.id_empleat + '-' + actor.id_calendar + '" id="actor-' + actor.id_empleat + '" class="actor-dia-' + pad(actor.dia) + '-' + actor.num_sala + '" autocomplete="off" value="0" '+(actor.asistencia == 1 ? 'checked' : '')+'> No present' +
                            '</label>' +
                            '<label class="btn btn-secondary '+(actor.asistencia === null ? 'active' : '')+'">' +
                                '<input type="radio" name="actor-' + actor.id_empleat + '-' + actor.id_calendar + '" id="actor-' + actor.id_empleat + '" class="actor-dia-' + pad(actor.dia) + '-' + actor.num_sala + '" autocomplete="off" value="null" '+(actor.asistencia == 1 ? 'checked' : '')+'> Pendent' +
                            '</label>' +
                        '</div>' +
                    '</td>';
                    var td2 = $(td2Value);
                    tr.append(td2);
                    $('#pasarLista-tabla').append(tr);
                });
            });
            
            $('.lista-actores').hide();
            $('.dia-' + parseInt(diaSeleccionado.split('-')[0]) + '-' + salaSeleccionada).show();
        },
        error: function (error) {
            console.error(error);
            alert("Error Llista Actors");
        }
    });
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    $.each(actores, function( key, element ) {
        if (element.id_actor == data) {
            persona = element; //persona es el elemento arrastrado
        }
    });
    if (getCookie("tablaActual")==0){
        celda = $(ev.target).attr('aria-valuenow') ? ev.target : ($(ev.target).parent().attr('dia') ? $(ev.target).parent() : $(ev.target).parent().parent());
    } else {
        celda = ev.target.parentElement.parentElement.parentElement.parentElement;
    }

    $('#exampleModal').modal('show');
}

function changeCalendar(que) {
    if (que == 0) {
        if (week == 1) {
            year = year - 1;
            week = weeksInYear(year);
        } else {
            week = week - 1;
        }
    } else if (que == 1) {
        if (week == weeksInYear(year)) {
            year = year + 1;
            week = 1;
        } else {
            week = week + 1;
        }
    }

    window.location = urlBase + '/' + year + '/' + week;

}

function cambiarColorCelda(celda, takes) {
    $(celda).attr('aria-valuenow', takes);
    $(celda).text(takes + '%');
    $(celda).css({ 'width': takes + '%' });
    if (takes < 25) {
        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-success';
    } else if (takes < 50) {
        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-info';
    } else if (takes < 75) {
        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-warning';
    } else if (takes <= 100) {
        $(celda)[0].className = 'progress-bar barra progress-bar-striped bg-danger';
    }
}


// Las siguientes dos funciones obtenidas de: https://stackoverflow.com/a/18479176
function getWeekNumber(d) {
    // Copy date so don't modify original
    d = new Date(+d);
    d.setHours(0, 0, 0);
    // Set to nearest Thursday: current date + 4 - current day number
    // Make Sunday's day number 7
    d.setDate(d.getDate() + 4 - (d.getDay() || 7));
    // Get first day of year
    var yearStart = new Date(d.getFullYear(), 0, 1);
    // Calculate full weeks to nearest Thursday
    var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
    // Return array of year and week number
    return [d.getFullYear(), weekNo];
}
function weeksInYear(year) {
    var d = new Date(year, 11, 31);
    var week = getWeekNumber(d)[1];
    return week == 1 ? getWeekNumber(d.setDate(24))[1] : week;
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

///// SIDEBAR /////

function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
    document.getElementsByTagName("main")[0].classList.add('contenedor-margen');
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: " + $('.sidebar-sticky').width() + "px !important";
    document.getElementsByTagName("main")[0].style.cssText = "width: calc(100% - 300px - " + $('.sidebar-sticky').width() + "px); !important";

    $('#btnAdd').hide();
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementsByTagName("main")[0].classList.remove('contenedor-margen');
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: auto !important";
    document.getElementsByTagName("main")[0].style.cssText = "width: 100% !important";
    $('#btnAdd').show();
}

//// MODALS /////

// Variables globales para guardar el dia y la sala que se han seleccionado al hacer clic en alguna celda:
var diaSeleccionado = "";
var salaSeleccionada = "";

function ampliarCasilla(e) {
    // Oculta todas las listas de los empleados de los modals.
    $('.lista-actores').hide();
    // Coge el atributo "dia" y "sala" de la celda seleccionada:
    diaSeleccionado = e.delegateTarget.getAttribute("dia");
    salaSeleccionada = e.delegateTarget.getAttribute("sala");
    // Muestra la lista en concreto con los empleado para poder "pasar lista":
    $('.dia-' + parseInt(diaSeleccionado.split('-')[0]) + '-' + salaSeleccionada).show();

    // TODO: Seleccionar a los técnicos dependiendo del día y la sala seleccionadas.
    
    $('#tecnico0').val('0');
    $('#tecnico1').val('0');
    
    $.each(tecnicsAsignados, function( key, element ) {
        if (element.num_sala == salaSeleccionada && element.data==diaSeleccionado){
            if (element.torn == 0){ //mañana
                if (element.id_empleat != 0){
                    $('#tecnico0').val(element.id_empleat);
                }
            } else if (element.torn == 1){ //tarde
                if (element.id_empleat != 0){
                    $('#tecnico1').val(element.id_empleat);
                }
            }
        }
    });

    $('#dialog').css({ 'width': window.innerWidth - 30 });
    $('#dialog').css({ 'max-width': window.innerWidth - 30 });
    $('#dialog').css({ 'height': window.innerHeight - 30 });
    $('#dialog').css({ 'max-height': window.innerHeight - 30 });
    $('#exampleModal2').modal('show');
}

$('#exampleModal').on('show.bs.modal', function (e) {
    var modal = $(this);

    /*let takes = 0;
    
    $.each(actores, function( key, element ) {
        if (element.id_actor == persona.id_actor) {
            takes = takes + element.takes_restantes;
        }
    });*/

    modal.find('.modal-title').text(persona.empleat.nom_cognom/* + ' - ' + takes + ' takes restants'*/);

    //takesPosibles = takes;

    if ($(celda).attr('dia')){
        var data_inici = $(celda).attr('dia');
        var num_sala = $(celda).attr('sala');
    } else {
        var data_inici = celda.parentElement.parentElement.getAttribute("dia");
        var num_sala = celda.parentElement.parentElement.getAttribute("sala");
    }
    
    $('#crear-subtitulo').text('Dia: '+data_inici+' - Sala: '+num_sala);
    $("#selectPelis").val('');
    //$('#numberTakes').attr('max', takesPosibles);
    $('#numberTakes').val('0');
    $('#numberTakes').removeAttr('readonly');
    $('#takesIni').val('');
    //$('#takesFin').val('');
    $("#actorEstadillo").val('-1');
    $("#opcio_calendar").val('0');
    //console.log(actores);
    var options = {
        data: actores.filter(filtroActorTk),
        placeholder: "Selecciona un registre",
        getValue: "nombre_reg_complet",

        list: {
                match: {
                    enabled: true
                }, onChooseEvent: function() {
                    var selected = $("#selectPelis").getSelectedItemData();
                    if (!$('#numberTakes').attr('readonly')) $('#numberTakes').val(selected.takes_restantes);
                    $('#actor').val(selected.id_actor);
                    $('#registreEntrada').val(selected.id_registre_entrada);      
                    $('#setmana').val(selected.setmana);      
                }, onHideListEvent: function() {
                    if ($("#selectPelis").val() == ''){
                        $("#actor").val('-1');
                        $("#registreEntrada").val('-1');
                        $("#setmana").val('-1');
                        $('#numberTakes').val(1);
                    }
                }
        },

        template: {
                type: "custom",
                method: function(value, item) {
                        return value;
                }
        },
    };

    $("#selectPelis").easyAutocomplete(options);
    var parentSearch = $('#selectPelis').parent().css({"width": "100%"});
    
    $("#opcio_calendar").change(function() {
        if($("#opcio_calendar").val() != 0) {
            $('#numberTakes').val('');
            $('#numberTakes').attr('readonly', '');
        } else {
            $.each(actores, function( key, element ) {
                if (element.id_actor == $('#actor').val() && element.id_registre_entrada == $('#registreEntrada').val() && element.setmana == $('#setmana').val()){
                    $('#numberTakes').val(element.takes_restantes);
                }
            });
            $('#numberTakes').removeAttr('readonly', '');
        }
    });
});
//Funccio per filtra un actor i si te més takes que 0
function filtroActorTk(e) {
    if (e.id_actor == persona.id_actor && e.takes_restantes > 0){
        return e;
    }
}

$('#exampleModal2').on('shown.bs.modal', function () {
    // Volvemos a llamar a esta función para volver a crear la tabla del modal, básicamente
    // para que cuando cambiemos de día no se visualice el contenido anterior.
    tablaHoras();

    pintarTablaHoras();
    
    $('#exampleModalLabel2').text('Sala: ' + salaSeleccionada + ' / Dia: ' + diaSeleccionado);
});

$('#exampleModal2').on('hide.bs.modal', function () {
    $('#tecnico0').removeClass("is-invalid");
    $('#tecnico1').removeClass("is-invalid");
    vaciarValoresEditar();
});

function pintarTablaHoras() {
    $.each(data, function( key, element ) {
        var ele_dia = element.data_inici.split(' ');

        // Si el día y la sala son los mismos que los seleccionados pintará la tabla:
        if (ele_dia[0] == diaSeleccionado && element.calendari.num_sala == salaSeleccionada) {
            var optimizarEsBueno = element.data_fi.split(' ');  // ¿A veces?

            var horaIni = ele_dia[1].split(':')[0];
            var horaFin = optimizarEsBueno[1].split(':')[0];
            var minIni = ele_dia[1].split(':')[1];
            var minFin = optimizarEsBueno[1].split(':')[1];

            for (let i = horaIni; i <= horaFin; i++) {
                if (i == horaFin) {
                    for (let h = 0; h < minFin; h++) {
                        pintar($('#td_' + i + '-' + pad(h)));
                    }
                } else if (i == horaIni) {
                    for (let h = minIni; h < 60; h++) {
                        pintar($('#td_' + i + '-' + pad(h)));
                    }
                } else {
                    for (let h = 0; h < 60; h++) {
                        pintar($('#td_' + i + '-' + pad(h)));
                    }
                }
            }
        }
    });
}

function tablaHoras() {
    var manyana = document.createElement('div');
    manyana.id = "morning";
    manyana.classList.add('row');
    var tarde = document.createElement('div');
    tarde.id = "evening";
    tarde.classList.add('row');

    // Vacia la tabla antigua:
    $('#tablaHoras').empty();

    $('#tablaHoras').append(manyana);
    //HACER TABLA DE HORAS
    $('#tablaHoras').append(tarde);

    for (let i = 8; i < 13; i++) {

        var hora = document.createElement('div');
        hora.id = pad(i) + ':30';

        var horaTextM = document.createElement('span');
        horaTextM.innerText = pad(i) + ':30';
        
        horaTextM.classList.add('labelFechaManana');
        hora.classList.add('col');
        hora.classList.add('celda2');
        $(hora).append(horaTextM);
        
        if (i == 12) {
            var horaTextM2 = document.createElement('span');
            horaTextM2.innerText = pad(i)+1 + ':30';
            
            $(horaTextM2).css('margin-left', '85%');
            
            horaTextM2.classList.add('labelFechaManana');
            $(hora).append(horaTextM2);
        }
        
        $('#morning').append(hora);

        var tableM = document.createElement('table');
        tableM.id = 'tableMinutosM';
        tableM.classList.add('tableP');
        var trM = document.createElement('tr');
        trM.id = "tr_" + pad(i);

        $(hora).append(tableM);
        $(tableM).append(trM);

        for (let m = 30; m < 90; m++) {
            var tdM = document.createElement('td')
            tdM.id = "td_" + (m < 60 ? pad(i) : pad((i + 1))) + "-" + (m < 60 ? pad(m) : pad((m - 60)));
            tdM.classList.add('tablaMinutos');
            $(trM).append(tdM);
        }
    }

    for (let i = 15; i < 20; i++) {
        var hora = document.createElement('div');

        var horaTextT = document.createElement('span');
        horaTextT.innerText = i + ':30';

        hora.id = i + ':30';
        hora.classList.add('col');
        hora.classList.add('celda2');
        horaTextT.classList.add('labelFechaTarde');
        $(hora).append(horaTextT);
        
        if (i == 19) {
            var horaTextT2 = document.createElement('span');
            horaTextT2.innerText = pad(i)+1 + ':30';
            
            $(horaTextT2).css('margin-left', '85%');
            
            horaTextT2.classList.add('labelFechaTarde');
            $(hora).append(horaTextT2);
        }
        
        $('#evening').append(hora);

        var tableT = document.createElement('table');
        tableT.id = 'tableMinutosT';
        tableT.classList.add('tableP');
        var trT = document.createElement('tr');
        trT.id = "tr_" + i;

        $(hora).append(tableT);
        $(tableT).append(trT);

        for (let m = 30; m < 90; m++) {
            var tdT = document.createElement('td');

            tdT.id = "td_" + (m < 60 ? i : (i + 1)) + "-" + (m < 60 ? m : pad((m - 60)));
            tdT.classList.add('tablaMinutosT');
            $(trT).append(tdT);
        }
    }
}

function pad(num) {
    return num < 10 ? '0' + num : num;
}

function pintar(elemento) {
    elemento.css({ 'background-color': 'red' });
}

///// CAMBIAR TÉCNICO /////
function cambiarTecnico(torn) {
    $.ajax({
        url: '/calendari/cambiarCargo',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            'id_empleat': parseInt($('#tecnico' + torn).val()),  // Ej: tecnico0, tecnico1
            'data': diaSeleccionado,
            'sala': salaSeleccionada,
            'cargo': 'Tècnic de sala',
            'torn': torn
        },
        success: function (response) {
            $('#tecnico0').removeClass("is-invalid");
            $('#tecnico1').removeClass("is-invalid");
            
            var newTec = 1;

            $.each(tecnicsAsignados, function( key, element ) {
                if (element.id_calendar_carrec == response.id_calendar_carrec) {
                    tecnicsAsignados[key] = response;
                    newTec = 0;
                }
            });
            
            if (newTec == 1){
                tecnicsAsignados.push(response);
            }

            resetCalendari();
        },
        error: function (error) {
            console.error(error);
            
            if (error.responseJSON.r == 1){
                $('#tecnico'+error.responseJSON.torn).addClass("is-invalid");
                alert("Aquest tècnic ja esta assignat.");
            } else {
               alert("No s'ha pogut canviar el tècnic."); 
            }
        }
    });
}

$('#pasarLista').click(function (e) {
    e.preventDefault();
    // Comprobación "chapucera" para comprobar que se ha hecho clic al botón "Desar llista":
    if (e.target.id == 'enviarListaAsistencia') {
        // Cogemos los campos del formulario el cual se está mostrando por pantalla.
        // Para ello es necesario hacer uso del día seleccionado y la sala seleccionada.
        // Los campos del formulario tienen la siguiente clase que vemos en la siguiente línea,
        // que gracias al día y a la sala podemos saber qué campos coger.
        var asistencia = $('#pasarLista .actor-dia-' + diaSeleccionado.split('-')[0] + '-' + salaSeleccionada);

        $.ajax({
            url: '/calendari/desarLlistaAsistencia',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },
            data: asistencia.serializeArray(),  // Le pasamos los datos serializados.
            success: function (response) { 
                $.each(data, function( key, element ) {    
                    $.each(response, function( key2, element2 ) {  
                        if (element.asistencia !== element2.asistencia && element.id_calendar === element2.id_calendar){
                            element.asistencia = element2.asistencia;
                        }
                    }); 
                });
                
                resetCalendari()
            },
            error: function (error) {
                console.error(error);
                alert("No s'ha pogut desar la llista :(");
            }
        });
    }
});

var calendarioActorSeleccionado_id = 0;
var calendarioActor = [];

// Elemento seleccionado de la lista de asistencia:
var elementoSeleccionado = undefined;

function seleccionarActorCalendario(id, elemento) {
    // Le da estilo al elemento seleccionado:
    if (elementoSeleccionado != undefined) {
        $(elementoSeleccionado).removeClass("actorAsistencia-seleccionado");
    }
    
    $(elemento).addClass("actorAsistencia-seleccionado");
    elementoSeleccionado = elemento;

    calendarioActorSeleccionado_id = id.split('-')[1];
    
    if (calendarioActorSeleccionado_id > 0) {
        $.ajax({
            url: '/calendari/cogerCalendarioActor',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },
            data: {
                id: calendarioActorSeleccionado_id
            },
            success: function (response) {
                calendarioActor = response;

                $('#selectPelis-editar').removeAttr('readonly');
                $('#selectPelis-editar').val(response.calendar.referencia_titol);
                $('#actor-editar').val(response.calendar.id_actor);
                $('#registreEntrada-editar').val(response.calendar.id_registre_entrada);
                $('#setmana-editar').val(response.calendar.setmana);
                
                if (response.calendar.director){
                    $('#selectDirector-editar').removeAttr('readonly');
                    $('#selectDirector-editar').val(response.calendar.director.nom_cognom);
                    $('#director-editar').val(response.calendar.id_director);
                } else {
                    $('#selectDirector-editar').removeAttr('readonly');
                    $('#selectDirector-editar').val('');
                    $('#director-editar').val('0'); 
                }

                if (response.calendar.opcio_calendar == 0) {
                    $('#numberTakes-editar').removeAttr('readonly');
                    $('#numberTakes-editar').val(response.calendar.num_takes);
                } else {
                    $('#numberTakes-editar').attr('readonly', '');
                    $('#numberTakes-editar').val('');
                }
                
                $('#takesIni-editar').removeAttr('readonly');
                $('#takesFin-editar').removeAttr('readonly');
                $('#opcio_calendar-editar').removeAttr('disabled');
                
                $('#takesIni-editar').val(response.calendar.data_inici.split(' ')[1]);
                $('#takesFin-editar').val(response.calendar.data_fi.split(' ')[1]);
                $('#opcio_calendar-editar').val(response.calendar.opcio_calendar);
                
                $('#botoEditar').removeAttr('disabled');
                $('#botoEliminarActor').removeAttr('disabled');
                
                var options = {
                    data: actores.filter(filtroActorTkEditar),
                    placeholder: "Selecciona registre",
                    getValue: "nombre_reg_complet",

                    list: {
                            match: {
                                enabled: true
                            }, onChooseEvent: function() {
                                var selected = $("#selectPelis-editar").getSelectedItemData();
                                if (!$('#numberTakes-editar').attr('readonly')) $('#numberTakes-editar').val(selected.takes_restantes);
                                $('#actor-editar').val(selected.id_actor);
                                $('#registreEntrada-editar').val(selected.id_registre_entrada);
                                $('#setmana-editar').val(selected.setmana);
                            }, onHideListEvent: function() {
                                if ($("#selectPelis-editar").val() == ''){
                                    $("#actor-editar").val('-1');
                                    $("#registreEntrada-editar").val('-1');
                                    $("#setmana-editar").val('-1');
                                }
                            }
                    },

                    template: {
                            type: "custom",
                            method: function(value, item) {
                                    return value;
                            }
                    },
                    
                    theme: "bootstrap"
                };

                $("#selectPelis-editar").easyAutocomplete(options);
                
                $("#opcio_calendar-editar").change(function() {
                    if($("#opcio_calendar-editar").val() != 0) {
                        $('#numberTakes-editar').val('');
                        $('#numberTakes-editar').attr('readonly', '');
                    } else {
                        $.each(actores, function( key, element ) {
                            if (element.id_actor == $('#actor-editar').val() && element.id_registre_entrada == $('#registreEntrada-editar').val() && element.setmana == $('#setmana-editar').val()){
                                $('#numberTakes-editar').val(element.takes_restantes);
                            }
                        });
                        $('#numberTakes-editar').removeAttr('readonly', '');
                    }
                });
                
                var options2 = {
                    url:  rutaSearchEmpleat+"?search=director",
                    placeholder: "Selecciona director",
                    getValue: "nom_cognom",

                    list: {
                            match: {
                                enabled: true
                            }, onChooseEvent: function() {
                                var selectedPost = $("#selectDirector-editar").getSelectedItemData();
                                $('#director-editar').val(selectedPost.id_empleat);
                            }, onHideListEvent: function() {
                                if ($("#selectDirector-editar").val() == ''){
                                    $("#director-editar").val('0');
                                }
                            }
                    },

                    template: {
                            type: "custom",
                            method: function(value, item) {
                                    return value;
                            }
                    },
                    
                    theme: "bootstrap"
                };

                $("#selectDirector-editar").easyAutocomplete(options2);
            },
            error: function (error) {
                console.error(error);
                alert("No s'ha obtingut les dades del calendari de l'actor.");
            }
        });
    }
}

function filtroActorTkEditar(e) {
    if (e.id_actor == calendarioActor.calendar.id_actor && e.takes_restantes > 0){
        return e;
    }
}

var options = {
    url: rutaSearchProduccio,
    placeholder: "Selecciona registre",
    getValue: "referencia_titol",

    list: {
            match: {
                enabled: true
            }
    },

};

$("#selectPelis-editar").easyAutocomplete(options);
var parentSearch = $('#selectPelis-editar').parent().css({"width": "100%"});

function editarActor() {
    $.ajax({
        url: '/calendari/editar/' + calendarioActorSeleccionado_id,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            id_actor: parseInt($('#actor-editar').val()),
            id_registre_entrada: parseInt($('#registreEntrada-editar').val()),
            setmana: parseInt($('#setmana-editar').val()),
            num_takes: $('#numberTakes-editar').val(),
            data_inici: $('#takesIni-editar').val(),
            data_fi: $('#takesFin-editar').val(),
            opcio_calendar: $('#opcio_calendar-editar').val(),
            num_sala: parseInt(calendarioActor.calendar.calendari.num_sala),
            id_director: parseInt($('#director-editar').val()),
        },
        success: function (response) {
            // Guarda los datos en la variable "data" y vuelve a recargar el calendario:
            $.each(data, function( key, element ) {
                if (element.id_calendar == calendarioActorSeleccionado_id) {
                    data[key] = response;
                }
            });

            resetCalendari();

            vaciarValoresEditar();
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha pogut modificar les dades del calendari.");
        }
    });
}

function eliminarCalendarioActor() {
    $.ajax({
        url: '/calendari/esborrar/' + calendarioActorSeleccionado_id,
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
        },
        success: function (response) {
            vaciarValoresEditar();

            actulitzarDades();
            
            actulitzarActors();
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha pogut esborrar l'event :(");
        }
    });
}

function vaciarValoresEditar() {
    $('#selectPelis-editar').attr('readonly', '');
    $('#selectPelis-editar').val('');
    $('#actor-editar').val(-1);
    $('#registreEntrada-editar').val(-1);
    $('#setmana-editar').val(-1);
    $('#selectDirector-editar').attr('readonly', '');
    $('#selectDirector-editar').val('');
    $('#director-editar').val(-1);
    $('#numberTakes-editar').val('');
    $('#numberTakes-editar').attr('readonly', '');
    $('#takesIni-editar').val('');
    $('#takesIni-editar').attr('readonly', '');
    $('#takesFin-editar').val('');
    $('#takesFin-editar').attr('readonly', '');
    $('#opcio_calendar-editar').val('0');
    $('#opcio_calendar-editar').attr('disabled', '');
    $('#botoEditar').attr('disabled', '');
    $('#botoEliminarActor').attr('disabled', '');
    
    calendarioActorSeleccionado_id = 0;
    $(elementoSeleccionado).removeClass('actorAsistencia-seleccionado');
}
//Funcio per obtenir el valor d'una cookie
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}