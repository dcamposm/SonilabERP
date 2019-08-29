$('#download-pdf').click(function() {
    $('[dia]').hide();
    
    var r = 0;
    $('.dayPrint:checked').each( function() {
        $('[dia="'+dias[$(this).val()]+'"]').show();
        r++;
    });
    
    if (r <= 0) {
        $('[dia]').show();
        return ;
    }
    
    $('.encabezado').hide();
    $('#calendar').css({
        "padding": "50px 0px 30px 55px",
    });
    $('[salarow="4"]').css('margin-bottom', '180px');
    
    var pdf = new jsPDF('l', 'pt', 'a3');
    pdf.internal.scaleFactor = 2.14;
    var options = {
         pagesplit: true
    };
    
    pdf.addHTML(document.getElementById('calendar'), 0, 0, options, function(){
    	//pdf.save('test.pdf');
        window.open(pdf.output('bloburl'), '_blank');
    });
    
    $('[salarow="4"]').css('margin-bottom', '0px');
    $('#calendar').css({
        "padding": "0px 15px 0px 15px"
    });
    $('.encabezado').show();
    $('[dia]').show();
});

$('#allDayPrint').on('click', function() {
    $(".dayPrint").prop("checked", this.checked);
});