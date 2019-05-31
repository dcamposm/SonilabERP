/////  INIT  /////

$('#semanaMenos').on('click', function () {
    changeCalendar(0)
})
$('#semanaMas').on('click', function () {
    changeCalendar(1)
})

$('#btnGuardar').click(guardarCelda)

$('#filtroActor').on('change', function(){
    filtrar()
})

$('#filtroProyecto').on('change', function(){
    filtrar()
})


crearTablaCalendario();
tablaHoras();
cargarDatos();

var persona = undefined
var takesPosibles = undefined

function crearTablaCalendario() {
    var contenedor = $('#calendarContent')
    for (let i = 0; i < 8; i++) {
        var fila = $('<div class="row fila"></div>')
        var sala = i + 1
        for (let h = 0; h < 6; h++) {
            if (h == 0) {
                // Crea un div con el número de la sala:
                fila.append('<div class="sala celda">' + sala + '</div>')
            } else {
                // Crea el día de la sala.
                // Es necesario crear el atributo "dia" y "sala", para que después cuando le hagamos clic
                // podamos coger el día y la sala de la casilla que hayamos seleccionado.
                fila.append('<div class="col celda" dia="' + dias[h - 1] + '" sala="' + sala + '"><div class="progress barra_progreso"><div class="progress-bar barra progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div></div></div>')
            }
        }
        contenedor.append(fila)
    }
    $('.celda').attr('ondrop', 'drop(event)')
    $('.celda').attr('ondragover', 'allowDrop(event)')
}

function cargarDatos() {
    data.forEach(element => {
        var celda = $("[dia=" + element.data_inici.split(' ')[0] + "][sala=" + element.num_sala + "]")[0].children[0].children[0]
        var takes = Number(celda.innerText.replace('%', '')) + element.num_takes
        celda.innerText = takes + '%'
        celda.style.width = takes + '%'
        celda.setAttribute('aria-valuenow', takes)
        cambiarColorCelda(celda, takes)
    });

    cargarActores();
    $('.celda').click(ampliarCasilla);
}

function cargarActores() {
    var trabajadores = {};
    actores.forEach(element => {
//        console.log(element)
        if (trabajadores[element.id_actor]){
            trabajadores[element.id_actor].takes_restantes = trabajadores[element.id_actor].takes_restantes + element.takes_restantes
        } else {
            trabajadores[element.id_actor] = {id_actor: element.id_actor, nombre_actor: element.nombre_actor, takes_restantes: element.takes_restantes}
        }
    })

    console.log(trabajadores);
    console.log(data);
    $('#trabajadores').html('');
    for (const key in trabajadores) {

        $('#trabajadores').append('<li id=' + trabajadores[key].id_actor + ' draggable="true" ondragstart="drag(event)">' + trabajadores[key].nombre_actor + ' - ' + trabajadores[key].takes_restantes + ' takes</li>');
    }
}

function filtrar(){
    var idActor = $('#filtroActor').val()
    var idProyecto = $('#filtroProyecto').val()

    console.log(dataBase)
    if (idActor != -1 && idProyecto != -1){
        data = dataBase.filter(item => item.actor_estadillo.id_actor == idActor)
        data = data.filter(item => item.actor_estadillo.registre_entrada.id_registre_entrada == idProyecto)
    } else if (idActor != -1){
        data = dataBase.filter(item => item.actor_estadillo.id_actor == idActor)
    } else if (idProyecto != -1){
        data = dataBase.filter(item => item.actor_estadillo.registre_entrada.id_registre_entrada == idProyecto)
    } else {
        data = dataBase
    }
    console.log(data)
    refrescarCalendarioFiltrado()
    cargarDatos()
}

///// FUNCTIONS /////

function refrescarCalendarioFiltrado(){
    $('#calendarContent').html('')
    crearTablaCalendario()
}

function guardarCelda() {
    var data_inici = celda.parentElement.parentElement.getAttribute("dia") + " " + $('#takesIni').val() + ":00";
    var data_fi = celda.parentElement.parentElement.getAttribute("dia") + " " + $('#takesFin').val() + ":00";
    var num_sala = celda.parentElement.parentElement.getAttribute("sala");

    let takes = Number($('#numberTakes').val())

    /** Comprobación errores inputs modal **/
    var errores = false
    if ($("#takesIni")[0].checkValidity() == false) {
        errores = true
    }
    if ($("#takesFin")[0].checkValidity() == false){
        errores = true
    } 
    if ($("#numberTakes")[0].checkValidity() == false) {
        errores = true
    }
    if (takesPosibles < takes){
        $("#numberTakes")[0].setCustomValidity('');
        errores = true
    }
    if (errores) return

    var datos = { id_actor_estadillo: persona.id_actor_estadillo, num_takes: takes, data_inici: data_inici, data_fi: data_fi, num_sala: num_sala };
    $.post('/calendari/crear', datos)
        .done(function (datosCalendari) {
            data.push(datosCalendari.calendari);

            let valorActual = Number($(celda).attr('aria-valuenow'))
            let takesSuma = takes + valorActual
            if (takes && takes > 0) {
                $(celda).attr('aria-valuenow', takesSuma)
                $(celda).text(takesSuma + '%')
                $(celda).css({ 'width': takesSuma + '%' })
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
            // trabajadores[persona[0]][2][$('#selectPelis').val()] = trabajadores[persona[0]][2][$('#selectPelis').val()] - takes
            actores.forEach(element => {
                if (element.id_registre_produccio == $('#selectPelis').val() && persona.id_actor == element.id_actor) {
                    element.takes_restantes = element.takes_restantes-takes;
                    
                }
            });
            cargarActores();
            console.log(actores);
        })
        .fail(function (error) {
            console.log(error);
        });



    //limpiarListado()
    //listarTrabajadores()
    $('#exampleModal').modal('hide');
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    actores.forEach(element => {
        if (element.id_actor == data) {
            persona = element; //persona es el elemento arrastrado
        }
    });

    celda = $(ev.target).attr('aria-valuenow') ? ev.target : ev.target.children[0]
    $('#exampleModal').modal('show');
}

function changeCalendar(que) {
    if (que == 0) {
        if (week == 1) {
            year = year - 1
            week = weeksInYear(year)
        } else {
            week = week - 1
        }
    } else if (que == 1) {
        if (week == weeksInYear(year)) {
            year = year + 1
            week = 1
        } else {
            week = week + 1
        }
    }

    window.location = urlBase + '/' + year + '/' + week

}

function cambiarColorCelda(celda, takes) {
    $(celda).attr('aria-valuenow', takes)
    $(celda).text(takes + '%')
    $(celda).css({ 'width': takes + '%' })
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
    var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7)
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
    document.getElementsByTagName("main")[0].classList.add('contenedor-margen')
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: " + $('.sidebar-sticky').width() + "px !important"
    document.getElementsByTagName("main")[0].style.cssText = "width: calc(100% - 300px - " + $('.sidebar-sticky').width() + "px); !important"

    $('#btnAdd').hide();
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementsByTagName("main")[0].classList.remove('contenedor-margen')
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: auto !important"
    document.getElementsByTagName("main")[0].style.cssText = "width: 100% !important"
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
    $('.dia-' + diaSeleccionado.split('-')[0] + '-' + salaSeleccionada).show();

    // TODO: Seleccionar a los técnicos y los directorios dependiendo del día y la sala seleccionadas.
    console.log(diaSeleccionado)
    console.log(salaSeleccionada)
    console.log(directoresAsignados)
    
    $('#director0').val('')
    $('#director1').val('')
    $('#tecnico0').val('')
    $('#tecnico1').val('')

    directoresAsignados.forEach(element => {
        if (element.num_sala == salaSeleccionada && element.data==diaSeleccionado){
            if (element.id_carrec == 2 ){ // director
                if (element.torn == 0){ //mañana
                    console.log('director por la mañana va')
                    console.log(element)
                    $('#director0').val(element.id_empleat)
                } else if (element.torn == 1){ //tarde
                    console.log('director por la tarde va')
                    console.log(element)
                    $('#director1').val(element.id_empleat)
                }
            } else if (element.id_carrec == 3){// técnico
                if (element.torn == 0){ //mañana
                    console.log('ténico por la mañana va')
                    console.log(element)
                    $('#tecnico0').val(element.id_empleat)
                } else if (element.torn == 1){ //tarde
                    console.log('técnico por la tarde va')
                    console.log(element)
                    $('#tecnico1').val(element.id_empleat)
                }
            }
        }
    });

    $('#dialog').css({ 'width': window.innerWidth - 30 })
    $('#dialog').css({ 'max-width': window.innerWidth - 30 })
    $('#dialog').css({ 'height': window.innerHeight - 30 })
    $('#dialog').css({ 'max-height': window.innerHeight - 30 })
    $('#exampleModal2').modal('show')
}

$('#exampleModal').on('show.bs.modal', function (event) {
    var modal = $(this)
    let takes = persona.takes_restantes;
    modal.find('.modal-title').text(persona.nombre_actor + ' - ' + takes + ' takes restants')

    var restantes = 100 - (celda.attributes['aria-valuenow'].value ? celda.attributes['aria-valuenow'].value : 0)

    takesPosibles = restantes > takes ? takes : restantes

    $('#numberTakes').attr('max', takesPosibles)
    $('#numberTakes').val('1')
    $('#takesIni').val('')
    $('#takesFin').val('')
    $('#takes-celda').text('Takes per assignar a la sala: ' + restantes)

    $('#selectPelis').html('')

    actores.forEach(actor => {

        if (actor.id_actor == persona.id_actor) {
            //console.log(actor.id_actor)
            $('#selectPelis').append(new Option(actor.nombre_reg_entrada + " " + actor.nombre_reg_produccio,actor.id_registre_produccio))

        }
    });



});

function inicializarSelectPeliculas() {
    // Inicializa el select de películas en caso de que esté vacío.
    var select = $('#selectPelis-editar');
    if (select[0].children.length == 0) {
        for (var i = 0; i < peliculas.length; i++) {
            select.append(new Option(peliculas[i].titol, peliculas[i].id));
        }
    }
}

$('#exampleModal2').on('shown.bs.modal', function () {
    inicializarSelectPeliculas();

    // Volvemos a llamar a esta función para volver a crear la tabla del modal, básicamente
    // para que cuando cambiemos de día no se visualice el contenido anterior.
    tablaHoras();

    data.forEach(element => {
        var ele_dia = element.data_inici.split(' ');

        // Si el día y la sala son los mismos que los seleccionados pintará la tabla:
        if (ele_dia[0] == diaSeleccionado && element.num_sala == salaSeleccionada) {
            var optimizarEsBueno = element.data_fi.split(' ');  // ¿A veces?

            var horaIni = ele_dia[1].split(':')[0]
            var horaFin = optimizarEsBueno[1].split(':')[0]
            var minIni = ele_dia[1].split(':')[1]
            var minFin = optimizarEsBueno[1].split(':')[1]

            for (let i = horaIni; i <= horaFin; i++) {
                if (i == horaFin) {
                    for (let h = 0; h < minFin; h++) {
                        pintar($('#td_' + i + '-' + pad(h)))
                    }
                } else if (i == horaIni) {
                    for (let h = minIni; h < 60; h++) {
                        pintar($('#td_' + i + '-' + pad(h)))
                    }
                } else {
                    for (let h = 0; h < 60; h++) {
                        pintar($('#td_' + pad(i) + '-' + pad(h)))
                    }
                }
            }
        }
    });
    $('#exampleModalLabel2').text('Sala: ' + salaSeleccionada + ' / Dia: ' + diaSeleccionado)
});

function tablaHoras() {

    var manyana = document.createElement('div')
    manyana.id = "morning"
    manyana.classList.add('row')
    var tarde = document.createElement('div')
    tarde.id = "evening"
    tarde.classList.add('row')

    // Vacia la tabla antigua:
    $('#tablaHoras').empty();

    $('#tablaHoras').append(manyana)
    //HACER TABLA DE HORAS
    $('#tablaHoras').append(tarde)

    for (let i = 8; i < 13; i++) {

        var hora = document.createElement('div')
        hora.id = pad(i) + ':30'

        var horaTextM = document.createElement('span')
        horaTextM.innerText = pad(i) + ':30'

        horaTextM.classList.add('labelFechaManana')
        hora.classList.add('col')
        hora.classList.add('celda')

        $(hora).append(horaTextM)
        $('#morning').append(hora)

        var tableM = document.createElement('table')
        tableM.id = 'tableMinutosM'
        tableM.classList.add('tableP')
        var trM = document.createElement('tr')
        trM.id = "tr_" + pad(i)

        $(hora).append(tableM)
        $(tableM).append(trM)

        for (let m = 1; m < 60; m++) {

            var tdM = document.createElement('td')
            tdM.id = "td_" + pad(i) + "-" + pad(m)
            tdM.classList.add('tablaMinutos')
            $(trM).append(tdM)
        }
    }

    for (let i = 15; i < 20; i++) {
        var hora = document.createElement('div')

        var horaTextT = document.createElement('span')
        horaTextT.innerText = i + ':30'


        hora.id = i + ':30'
        hora.classList.add('col')
        hora.classList.add('celda')
        horaTextT.classList.add('labelFechaTarde')
        $(hora).append(horaTextT)
        $('#evening').append(hora)

        var tableT = document.createElement('table')
        tableT.id = 'tableMinutosT'
        tableT.classList.add('tableP')
        var trT = document.createElement('tr')
        trT.id = "tr_" + i

        //$(hora).append(divTableM)
        $(hora).append(tableT)
        $(tableT).append(trT)

        for (let m = 30; m < 90; m++) {

            var tdT = document.createElement('td')

            tdT.id = "td_" + (m < 60 ? i : (i + 1)) + "-" + (m < 60 ? m : pad((m - 60)))
            tdT.classList.add('tablaMinutosT')
            $(trT).append(tdT)
        }
    }
    /*
        8:30 13:30
        15:30 20:30*/
}

function pad(num) {
    return num < 10 ? '0' + num : num
}

function pintar(elemento) {
    elemento.css({ 'background-color': 'red' })
}


///// CAMBIAR TÉCNICO Y DIRECTOR /////
function cambiarDirector(torn) {
    $.ajax({
        url: '/calendari/cambiarCargo',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            'id_empleat': $('#director' + torn).val(),  // Ej: director0, director1
            'data': diaSeleccionado,
            'sala': salaSeleccionada,
            'cargo': 'Director',
            'torn': torn
        },
        success: function (response) {
            console.log(response);
            // TODO: Poner el id_empleado nuevo en el array, para que cuando se vuelva a abrir esté ya cambiado.
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha pogut canviar el director :(");
        }
    });
}

function cambiarTecnico(torn) {
    $.ajax({
        url: '/calendari/cambiarCargo',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            'id_empleat': $('#tecnico' + torn).val(),  // Ej: tecnico0, tecnico1
            'data': diaSeleccionado,
            'sala': salaSeleccionada,
            'cargo': 'Tècnic de sala',
            'torn': torn
        },
        success: function (response) {
            console.log(response);
            // TODO: Poner el id_empleado nuevo en el array, para que cuando se vuelva a abrir esté ya cambiado.
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha pogut canviar el tècnic :(");
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
        console.log(asistencia.serializeArray());

        $.ajax({
            url: '/calendari/desarLlistaAsistencia',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },
            data: asistencia.serializeArray(),  // Le pasamos los datos serializados.
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.error(error);
                alert("No s'ha pogut desar la llista :(");
            }
        });
    }
});

// Esto es para que cuando se haga clic a un objeto con la clase "btn" no se lance el evento del formulario al que pertenece.
// Se ha realizado este función para no ejecutar un formulario cuando se le da clic a un elemento que tenga esta clase.
// ¡SE ACEPTAN SOLUCIONES MEJORES A ESTO!
$('.btn').click(function(e) {
    e.preventDefault();
});

var calendarioActorSeleccionado = 0;
var peliculas = [];

function cargarPeliculas() {
    $.ajax({
        url: '/calendari/getPeliculas',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        success: function (response) {
            console.log(response);
            peliculas = response;
            // TODO: Asignar los respectivos campos al formulario de editar.
        },
        error: function (error) {
            console.error(error);
            alert("No s'ha obtenir les dades de calendari de l'actor :(");
        }
    });
}
cargarPeliculas();

function editarActorCalendario(id) {
    calendarioActorSeleccionado = id.split('-')[1];

    if (calendarioActorSeleccionado > 0) {
        $.ajax({
            url: '/calendari/cogerCalendarioActor',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                Accept: 'application/json'
            },
            data: {
                id: calendarioActorSeleccionado
            },
            success: function (response) {
                console.log(response);
                $('#numberTakes-editar').val(response.num_takes);
                $('#takesIni-editar').val(response.data_inici.split(' ')[1]);
                $('#takesFin-editar').val(response.data_fi.split(' ')[1]);
                
                //$('#selectPelis-editar').val(response.id);
                // TODO: Asignar los respectivos campos al formulario de editar.
            },
            error: function (error) {
                console.error(error);
                alert("No s'ha obtenir les dades de calendari de l'actor :(");
            }
        });
    }
}

function editarActor() {
    // TODO:

}

function eliminarCalendarioActor() {
    // TODO:
    
}