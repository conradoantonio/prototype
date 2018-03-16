//Autor: Luis Castañeda
//Plagiado por: Conrado Carrillo
function ajaxForm(form_id, config) {
    var formData = new FormData($("form#"+form_id)[0]);
    var button = $("form#"+form_id).find('button.save');
    $.ajax({
        method: "POST",
        url: $("form#"+form_id).attr('action'),
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(data) {
            swal.close();
            swal({
                title: 'Bien: ',
                icon: data.status ? data.status : "success",
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Cambios guardados exitosamente!"+"</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);

            if (config.refresh) {
                refreshTable(data.url, config.column, config.table_id, config.tabla_contenedor);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
        }
    });
}

function ajaxSimple(config) {
    $.ajax({
        method: config.method ? config.method : "POST",
        url: config.route,
        data: config,
        success: function(data) {
            $('div.modal').modal('hide');
            swal.close();
            if (config.refresh) {
                refreshTable(data.url, config.column, config.table_id, config.tabla_contenedor);
            } else if(config.redirect) {
                setTimeout( function() {
                    window.location.href = data.url;
                }, '2000');
            }
        },
        error: function(xhr, status, error) {
            displayAjaxError(xhr, status, error);
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

function refreshTable(url, column, table_id, container_id) {
    var table = table_id ? $("table#"+table_id).dataTable() : $("table#example3").dataTable();
    var container = container_id ? $("div#"+container_id) : $('div#table-container');
    table.fnDestroy();
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
        $(table_id ? "table#"+table_id : "table#example3").dataTable({
            "aaSorting": [[ column ? column : 1, "desc" ]]
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
    if (modal_id) {
        $('div#'+modal_id).modal();
    }
}

function displayAjaxError(xhr, status, error) {
    swal.close();
    if (/^[\],:{}\s]*$/.test(xhr.responseText.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
        display = JSON.parse(xhr.responseText).msg;
    } else {
        display = '';
    }
    swal({
        title: '¡Error!',
        icon: 'error',
        content: {
            element: "div",
            attributes: {
                innerHTML:"Se encontró un problema guardando cambios: <br><span>" + display + "</span><br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>"
            },
        },
    }).catch(swal.noop);
}
