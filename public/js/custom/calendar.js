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