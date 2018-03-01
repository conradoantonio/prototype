//Autor: Luis Castañeda
//Plagiado por: Conrado Carrillo
function ajaxForm(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    var button = $("form#"+form_id).find('button.guardar-form');
    $.ajax({
        method: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            button.children('i.fa-spin').hide();
            button.attr('disabled', false);
            $('div.modal').modal('hide');
            swal({
                title: "<small>Bien</small>",
                text: data.msg ? data.msg : "¡Cambios guardados exitosamente!",
                type: data.status ? data.status : "success",
                showLoaderOnConfirm: false,
                html: true,
                timer: 2000
            });
            refreshTable(window.location.href, config.columna, config.tabla_id, config.tabla_contenedor);
        },
        error: function(xhr, status, error) {
            $('div.modal').modal('hide');
            button.children('i').hide();
            button.attr('disabled', false);
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando los datos: <br><span>" + JSON.parse(xhr.responseText).msg + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                html: true
            });
        }
    });
}

function ajaxMultiple(data) {
    url = baseUrl.concat(data.url);
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function(data) {
            $('div.modal').modal('hide');
            swal({
                title: "<small>Bien</small>",
                text: data.msg ? data.msg : "¡Cambios guardados exitosamente!",
                type: data.status ? data.status : "success",
                showLoaderOnConfirm: false,
                html: true
            });
            refreshTable(window.location.href, data.columna, data.tabla_id, data.tabla_contenedor);
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema guardando cambios, por favor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                type: 'error',
                html: true
            });
        }
    });
}

function ajaxMSimple(data) {
    url = baseUrl.concat(data.url);
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        success: function(response) {
            $( ".fill-container" ).addClass('hide');
            fill_text(response,data.modal_id);
            
            if (response.cancelacion) {
                fill_text(response.cancelacion, null);
            }
            
            $("table#detalles tbody").children().remove();

            /*Detalles de pedido (Productos)*/
            items = response.detalles;
            for (var key in items) {
                if (items.hasOwnProperty(key)) {
                    $("table#detalles tbody").append(
                        '<tr>'+
                            '<td class="text-center">'+items[key].nombre+'</td>'+
                            '<td class="text-center">$'+(items[key].precio / 100)+'</td>'+
                            '<td class="text-center">'+(items[key].cantidad)+'</td>'+
                            '<td class="text-center">$'+((items[key].precio * items[key].cantidad) / 100)+'</td>'+
                        '</tr>'
                    );
                }
            }

            $("table#detalles tbody").append(
                '<tr>'+
                    '<td class="text-center"></td>'+
                    '<td class="text-center"></td>'+
                    '<td class="text-center bold">Costo total</td>'+
                    '<td class="text-center">$'+(response.costo_total/100)+'</td>'+
                '</tr>'
            );
        },
        error: function(xhr, status, error) {
            swal({
                title: "<small>¡Error!</small>",
                text: "Se encontró un problema con el servidor, por favor, trate nuevamente.<br><span>" + JSON.parse(xhr.responseText).msg + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                type: 'error',
                html: true
            });
        }
    });
}

function refreshTable(url, columna, tabla_id, id_container) {
    var table = tabla_id ? $("table#"+tabla_id).dataTable() : $("table#example3").dataTable();
    var container = id_container ? $("div#"+id_container) : $('div#table_container');
    table.fnDestroy();
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
        $(tabla_id ? "table#"+tabla_id : "table#example3").dataTable({
            "aaSorting": [[ columna ? columna : 1, "desc" ]]
        });
    });
}

function fill_text(response, modal_id) {
    //$( ".fill-container" ).addClass('hide');
    var keyNames = Object.keys(response);

    for (var i in keyNames) {
        prop_name = keyNames[i];
        if (response[prop_name]) {
            $( ".data-fill" ).find( "."+prop_name ).text(response[prop_name]);
            $( ".data-fill" ).find( "."+prop_name ).closest('.fill-container').removeClass('hide');
        }
    }
    if (modal_id){
        $('div#'+modal_id).modal();
    }
}
