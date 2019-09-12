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
    
    if ($('.orientation:checked').val() == "l") {
        $('#calendar').css({
            "padding": "50px 0px 30px 55px",
            "margin-right": "30px"
        });    
        
        $('[salarow="4"]').css('margin-bottom', '180px');
    } else {
        if (r > 1) {
            $('#calendar').css({
                "padding": "50px 0px 30px 85px",
                "min-width": "1600px"
            });
        } else {
            $('#calendar').css({
                "padding": "50px 0px 30px 85px",
                "margin-right": "1600px",
                "min-width": "880px"
            });
        }
        
        $('[salarow="5"]').css('margin-bottom', '400px');
    }

    var pdf = new jsPDF(''+$('.orientation:checked').val()+'', 'pt', 'a3');
    
    if ($('.orientation:checked').val() == "l") pdf.internal.scaleFactor = 2.14;
    else pdf.internal.scaleFactor = 2;
    
    var options = {
         pagesplit: true
    };
    
    pdf.addHTML(document.getElementById('calendar'), 0, 0, options, function(){
    	//pdf.save('test.pdf'); //Per descarregar directament
        window.open(pdf.output('bloburl'), '_blank');
    });
    
    $('[salarow]').css('margin-bottom', '0px');
    $('#calendar').css({
        "padding": "0px 15px 0px 15px",
        "min-width": "2500px"
    });
    $('.encabezado').show();
    $('[dia]').show();
});

$('#allDayPrint').on('click', function() {
    $(".dayPrint").prop("checked", this.checked);
});