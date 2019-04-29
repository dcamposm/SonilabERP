/////  INIT  /////

$('#semanaMenos').on('click', function(){
    changeCalendar(0)
})
$('#semanaMas').on('click', function(){
    changeCalendar(1)
})

crearTablaCalendario()

function crearTablaCalendario(){
    var contenedor = $('#contenedor')
    for (let i = 0; i < 8; i++) {
        var fila = $('<div class="row fila"></div>')
        for (let h = 0; h < 6; h++) {
            if (h == 0){
                fila.append('<div class="sala celda">'+(i+1)+'</div>')
            } else {
                fila.append('<div class="col celda"><div class="progress barra_progreso"><div class="progress-bar barra progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div></div></div>')
            }
        }      
        contenedor.append(fila)
    }
}

///// FUNCTIONS /////

function changeCalendar(que){
    if (que == 0){
        if (week == 1){
            year = year - 1
            week = weeksInYear(year)
        } else {
            week = week - 1
        }
    } else if (que == 1){
        if (week == weeksInYear(year)){
            year = year + 1
            week = 1
        } else {
            week = week + 1
        }
    }

    window.location = urlBase + '/' + year + '/' + week

}


// Las siguientes dos funciones obtenidas de: https://stackoverflow.com/a/18479176
function getWeekNumber(d) {
    // Copy date so don't modify original
    d = new Date(+d);
    d.setHours(0,0,0);
    // Set to nearest Thursday: current date + 4 - current day number
    // Make Sunday's day number 7
    d.setDate(d.getDate() + 4 - (d.getDay()||7));
    // Get first day of year
    var yearStart = new Date(d.getFullYear(),0,1);
    // Calculate full weeks to nearest Thursday
    var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7)
    // Return array of year and week number
    return [d.getFullYear(), weekNo];
}
function weeksInYear(year) {
    var d = new Date(year, 11, 31);
    var week = getWeekNumber(d)[1];
    return week == 1? getWeekNumber(d.setDate(24))[1] : week;
}

///// SIDEBAR /////

function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
    document.getElementsByTagName("main")[0].classList.add('contenedor-margen')
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: "+$('.sidebar-sticky').width()+"px !important"
    document.getElementsByTagName("main")[0].style.cssText = "width: calc(100% - 300px - "+$('.sidebar-sticky').width()+"px); !important"   

    $('#btnAdd').hide();
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementsByTagName("main")[0].classList.remove('contenedor-margen')
    document.getElementsByTagName("main")[0].style.cssText = "margin-left: auto !important"
    document.getElementsByTagName("main")[0].style.cssText = "width: 100% !important"
    $('#btnAdd').show();
}