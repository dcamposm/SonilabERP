var optionsActorSide = {
    data:  empleats,
    placeholder: "Seleccionar actor",
    getValue: "nom_cognom",
    
    list: {
            match: {
                enabled: true
            }, onChooseEvent: function() {
                var selectedPost = $("#selectActor").getSelectedItemData();

                $("#id_actor").val(selectedPost.id_actor);
                
                if (empleatsPack) {
                    var actorPack = empleatsPack.filter(function (e) {
                        if (e.id_actor == selectedPost.id_actor){
                            return e;
                        }
                    });
                    
                    $.each(actorPack, function( key, element ) {  
                        $("#take_estadillo_"+element.id_produccio).val(element.take_estadillo);
                        $("#cg_estadillo_"+element.id_produccio).val(element.cg_estadillo);
                        element.canso_estadillo == 1 ? $("#canso_estadillo_"+element.id_produccio).prop('checked', true) : $("#canso_estadillo_"+element.id_produccio).prop('checked', false);
                        element.narracio_estadillo == 1 ? $("#narracio_estadillo_"+element.id_produccio).prop('checked', true) : $("#narracio_estadillo_"+element.id_produccio).prop('checked', false);
                    });
                } else if (selectedPost.hasOwnProperty('take_estadillo')){
                    $("#take_estadillo").val(selectedPost.take_estadillo);
                    $("#cg_estadillo").val(selectedPost.cg_estadillo);
                    selectedPost.canso_estadillo == 1 ? $("#canso_estadillo").prop('checked', true) : $("#canso_estadillo").prop('checked', false);
                    selectedPost.narracio_estadillo == 1 ? $("#narracio_estadillo").prop('checked', true) : $("#narracio_estadillo").prop('checked', false);
                }
            }, onHideListEvent: function() {
                if ($("#selectActor").val() == ''){
                    $("#id_actor").val('');
                }
            }
    },
    
    template: {
            type: "custom",
            method: function(value, item) {
                    return value;
            }
    },
};

$("#selectActor").easyAutocomplete(optionsActorSide);