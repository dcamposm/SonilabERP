var self = this;
self.clientPerEsborrar = 0;

// Executa el formulari per mostrar la vista d'un client.
self.mostrarClient = function (urlShow) {
    window.location.replace(urlShow);
}

// Emmagatzema l'identificador d'un client i mostra un missatge en el modal d'esborrar.
self.seleccionarClient = function (clientId, clientAlias) {
    self.clientPerEsborrar = clientId;
    if (clientAlias != undefined) {
        document.getElementById('delete-message').innerHTML = 'Vols esborrar el client <b>' + clientAlias + '</b>?';
    }
}

// Esborra el client seleccionat.
self.esborrarClient = function () {
    if (self.clientPerEsborrar != 0) {
        document.all["delete-" + self.clientPerEsborrar].submit(); 
    }
}

$("#table").tablesorter({
    theme : "bootstrap",
    
    headerTemplate: '{content} {icon}'
});
