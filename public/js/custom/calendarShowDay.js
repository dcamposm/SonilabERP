function showDay(day) {
    $.ajax({
        url: '/calendari/day/',
        type: 'get',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            day: day
        },
        success: function (response) {
            $('#headerCotent').hide();
            $('.encabezado').hide();
            $('#calendarContent').html('');
            $('#calendar').css('min-width', '800px');            
            for (let i = 0; i < 8; i++) {
                var sala = i + 1;
                var fila = $('<div class="row fila"></div>');
                var tecnicMati = response.tecnics.filter(function (e){
                    if (e.num_sala == sala && e.torn == 0){
                        return e;
                    }
                });
                
                var tecnicTarda = response.tecnics.filter(function (e){
                    if (e.num_sala == sala && e.torn == 1){
                        return e;
                    }
                });
                fila.append('<div class="sala celda numS">' + sala + '</div>');
                fila.append('<div class="sala celda" style="min-height: 200px;">\n\
                                <div class="col torns">\n\
                                    <div class="row tornM">\n\
                                        <div class="rotarM">Matí</div>\n\
                                    </div>\n\
                                    <div class="row tornT">\n\
                                        <div class="rotarT">Tarda</div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>'
                        );
                fila.append('<div class="col celda" sala="'+sala+'" style="min-height: 200px;">\n\
                                <div class="row rowMati">\n\
                                    <div class="col colGlob">\n\
                                        <div class="row det">\n\
                                            <div class="rotar2" style="'+ (!tecnicMati[0]  ? '' : (!tecnicMati[0].empleat ? 'border-right: 1px solid black;' : 'background-color: '+tecnicMati[0].empleat.color_empleat+';'+(tecnicMati[0].empleat.color_empleat == '#000000' ? 'color: #FFFFFF' : 'color: #000000')+'; border-left: 1px solid black;')) +'">'+ (!tecnicMati[0] ? '' : (!tecnicMati[0].empleat ? '' : (tecnicMati[0].empleat.nom_empleat).split(' ')[0])) +'</div>\n\
                                            <div class="col mati"></div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="row rowTarda">\n\
                                    <div class="col colGlob">\n\
                                        <div class="row det">\n\
                                            <div class="rotar2" style="'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? 'border-right: 1px solid black;' : 'background-color: '+tecnicTarda[0].empleat.color_empleat+';'+(tecnicTarda[0].empleat.color_empleat == '#000000' ? 'color: #FFFFFF' : 'color: #000000')+'; border-left: 1px solid black;')) +'">'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? '' : (tecnicTarda[0].empleat.nom_empleat).split(' ')[0]) ) +'</div>\n\
                                            <div class="col tarda"></div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>'
                );
        
                $('#calendarContent').append(fila);
            }
            
            $.each(response.data, function( key, element ) {   
                if (element.data_inici.split(' ')[1] <= '13:30') {
                    var actorSala = '<div class="row '+(element.asistencia === 0 ? 'actorNoPres' : '')+'">\
                                        <div class="col-1 llistaActors">'+element.data_inici.split(' ')[1]+'</div>\n\
                                        <div class="col-3 llistaActors">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                        <div class="col-1 llistaActors">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                        <div class="col-5 llistaActors" style="'+(!element.registre_entrada || element.asistencia === 0 ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                        <div class="llistaActors">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
                                    </div>';
                    $("[sala=" + element.calendari.num_sala + "]").children().children().children().children('.mati').append(actorSala);
                } else {
                    var actorSala = '<div class="row '+(element.asistencia === 0 ? 'actorNoPres' : '')+'">\n\
                                        <div class="col-1 llistaActors">'+element.data_inici.split(' ')[1]+'</div>\n\
                                        <div class="col-3 llistaActors">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                        <div class="col-1 llistaActors">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                        <div class="col-5 llistaActors" style="'+(!element.registre_entrada || element.asistencia === 0 ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                        <div class="llistaActors">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
                                    </div>';
                    $("[sala=" + element.calendari.num_sala + "]").children().children().children().children('.tarda').append(actorSala);
                }
            });

            $('#contenedor').append('<a class="btn btn-primary mt-3" id="tornar">\n\
                                        <span class="fas fa-angle-double-left"></span>\n\
                                        TORNAR\n\
                                    </a> ');
            
            $('#tornar').on('click', function () {
                returnCalendar();
            });
        },
        error: function (error) {
            console.error(error);
            alert("Error Actualitzar Actors");
        }
    });
}

function returnCalendar(){
    $('#headerCotent').show();
    $('.encabezado').show();
    $('#tornar').remove();
    resetCalendari();
}