base_url = $('#token').attr('base-url');//Extrae la base url del input token de la vista

function guardarBanner(button) {
    var formData = new FormData($("form#form_banner")[0]);
    $.ajax({
        method: "POST",
        url: $("form#form_banner").attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i').hide();
            button.attr('disabled', false);
            $('div#formulario_banner').modal('hide');
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            $('div#formulario_banner').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando los datos, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function eliminarBanner(id) {
    url = base_url.concat('/banners/eliminar');
    $.ajax({
        method: "POST",
        url: url,
        data:{
            "id":id
        },
        success: function() {
            refreshTable(window.location.href);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>Error!</small>",
                text: "Se encontró un problema eliminando el banner, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function refreshTable(url) {
    var table = $("table#example3").dataTable();
    table.fnDestroy();
    $('div#table_container').fadeOut();
    $('div#table_container').empty();
    $('div#table_container').load(url, function() {
        $('div#table_container').fadeIn();
        $("table#example3").dataTable({
            "aaSorting": [[ 1, "desc" ]]
        });
    });
}