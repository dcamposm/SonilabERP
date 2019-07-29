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
            
            var fila = $('<div class="row fila" style="min-width: 3000px;"></div>');
            for (let i = 0; i < 8; i++) {
                var sala = i + 1;
               
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

                fila.append('<div class="col celda" sala="'+sala+'" style="min-height: 200px;">\n\
                                <div class="row rowHeader">\n\
                                    <div class="col col-fecha-H">'+sala+'</div>\n\
                                </div>\n\
                                <div class="row rowMati">\n\
                                    <div class="col colGlob">\n\
                                        <div class="row det">\n\
                                            <div class="viewTecnic" style="'+ (!tecnicMati[0]  ? '' : (!tecnicMati[0].empleat ? 'border-left: 1px solid black;' : 'background-color: '+tecnicMati[0].empleat.color_empleat+'; border-right: 1px solid black;')) +'"><div class="rotar">'+ (!tecnicMati[0] ? '' : (!tecnicMati[0].empleat ? '' : tecnicMati[0].empleat.nom_empleat)) +'</div></div>\n\
                                            <div class="col mati"></div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="row rowTarda">\n\
                                    <div class="col colGlob">\n\
                                        <div class="row det">\n\
                                            <div class="viewTecnic" style="'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? 'border-left: 1px solid black;' : 'background-color: '+tecnicTarda[0].empleat.color_empleat+'; border-right: 1px solid black;')) +'"><div class="rotar">'+ (!tecnicTarda[0] ? '' : (!tecnicTarda[0].empleat ? '' : tecnicTarda[0].empleat.nom_empleat) ) +'</div></div>\n\
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
                                        <div class="llistaActors" style="padding-left: 5px; padding-right: 1px;">'+element.data_inici.split(' ')[1]+'</div>\n\
                                        <div class="col-4 llistaActors" style="padding-left: 1px; padding-right: 1px;">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                        <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                        <div class="col-4 llistaActors" style="padding-left: 1px; padding-right: 1px; '+(!element.registre_entrada || element.asistencia === 0 ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                        <div class="llistaActors" style="padding-left: 1px; padding-right: 1px;">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
                                    </div>';
                    $("[sala=" + element.calendari.num_sala + "]").children().children().children().children('.mati').append(actorSala);
                } else {
                    var actorSala = '<div class="row '+(element.asistencia === 0 ? 'actorNoPres' : '')+'">\n\
                                        <div class="llistaActors" style="padding-left: 5px; padding-right: 1px;">'+element.data_inici.split(' ')[1]+'</div>\n\
                                        <div class="col-4 llistaActors" style="padding-left: 1px; padding-right: 1px;">'+element.actor.cognom1_empleat+' '+element.actor.nom_empleat+'</div>\n\
                                        <div class="llistaActors" style="padding-left: 5px; padding-right: 5px;">'+(element.opcio_calendar == 0 ? (element.num_takes+'TK') : (element.opcio_calendar).toUpperCase())+'</div>\n\
                                        <div class="col-4 llistaActors" style="padding-left: 1px; padding-right: 1px; '+(!element.registre_entrada || element.asistencia === 0 ? '' : ('background-color: '+element.registre_entrada.color_referencia+';'))+'">'+element.referencia_titol+'</div>\n\
                                        <div class="llistaActors" style="padding-left: 1px; padding-right: 1px;">'+(element.id_director != 0 ? element.director.nom_empleat : '')+'</div>\n\
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