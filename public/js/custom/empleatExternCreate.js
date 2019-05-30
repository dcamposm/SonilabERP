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