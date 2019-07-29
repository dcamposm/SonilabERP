$('#download-pdf').click(function() {
    $('.encabezado').hide();
    $('#calendar').css('padding-top', '52px');
    
    var pdf = new jsPDF('l', 'pt', 'a3');
    pdf.internal.scaleFactor = 2;
    var options = {
         pagesplit: true
    };
    pdf.addHTML(document.getElementById('calendar'), 0, 0, options, function(){
    	//pdf.save('test.pdf');
        window.open(pdf.output('bloburl'), '_blank');
    });
    
    $('#calendar').css('padding-top', '');
    $('.encabezado').show();
 });