function putInput(){
    var venda = parseFloat($('#preuVenda').text()).toFixed(2);
    
    $('#preuVenda').text('');
    $('#preuVenda').append('<input type="text" name="preu_venda" id="preu_venda" value="'+venda+'" class="form-control">');
    $(this).hide();
    $('#update').hide();
    $('#save').show();
    
    $('#preu_venda').keyup(calculPercentatge);
}

function calculPercentatge(){
    var total = parseFloat($('#costosTotals').text());
    var venda = parseFloat($('#preu_venda').val()).toFixed(2);
    var per = 100-(total/venda*100);

    if (per >= -100) $('#percen').text(per.toFixed(2));
    else $('#percen').text('');
}

function calculPercentatge2(){
    var total = parseFloat($('#costosTotals').text());
    var venda = parseFloat($('#preuVenda').text()).toFixed(2);
    var per = 100-(total/venda*100);

    if (per >= -100) $('#percen').text(per.toFixed(2));
    else $('#percen').text();
}

function saveVenda(){
    if ($('#percen').text() == ''){
        $('#preu_venda').addClass("is-invalid");
        return ;
    }
    $.ajax({
        url: '/vec/setPreuVenda',
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: 'application/json'
        },
        data: {
            id: vec['id_registre_produccio'] ? vec['id_registre_produccio'] : vec['ref'],
            setmana: vec['setmana'] ? vec['setmana'] : 0,
            preu_venda: parseFloat($('#preu_venda').val()).toFixed(2)
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.error(error);
        }
    });
}

$('#mod').click(putInput);
$('#save').click(saveVenda);

calculPercentatge2();