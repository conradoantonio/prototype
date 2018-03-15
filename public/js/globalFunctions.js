$(function(){
    $('div.modal').on('hidden.bs.modal', function (e) {
        $(this).find('div.form-group').removeClass('has-error');
        $(this).find("input.form-control").val('');
        $(this).find("select.form-control").val(0);
    });

    $('body').delegate('.delete-rowssdasd','click', function() {
        $("form#noticias").get(0).setAttribute('action', $(this).data('url'));
        $('h4#titulo_form_noticias').text('Nueva pregunta frecuente');
        $("#form_noticia .form-control").val('');
        $("div#foto").hide();
        $('#form_noticia').modal();
    });

    $('body').delegate('.delete-rowsasdas','click', function() {
        var noticia_id = $(this).parent().siblings("td:nth-child(1)").text();
        var token = $("#token").val();
        var id = $(this).parent().parent().attr('id');

        swal({
            title: "¿Realmente desea eliminar la pregunta frecuente con el id " + "<span style='color:#F8BB86'>" + noticia_id + "</span>?",
            text: "¡Cuidado!",
            html: true,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, continuar",
            showLoaderOnConfirm: true,
            allowEscapeKey: true,
            allowOutsideClick: true,
            closeOnConfirm: false
        },
        function() {
            //eliminarNoticia(id,token);
        });
    });

    $('body').delegate('.delete-rows','click', function() {
        var route = $(this).data('url');
        var ids_array = [];
        $("input.checkDelete").each(function() {
            if($(this).is(':checked')) {
                ids_array.push($(this).parent().parent().parent().attr('id'));
            }
        });
        if (ids_array.length > 0) {
            
            swal({
                title: 'Se eliminarán '+ids.length+' registro(s), ¿Estás seguro?',
                icon: 'warning',
                buttons:["Cancelar", "Aceptar"],
                dangerMode: true,
            }).then((accept) => {
                if (accept){
                    $.ajax({
                        url: url,
                        type:"DELETE",
                        data:{
                            ids: ids
                        },
                        success:function(response){
                            if (response.delete == "true"){
                                swal({
                                    title: 'Registro eliminado exitosamente',
                                    icon: 'success',
                                }).then((accept) => {
                                    if (accept) {
                                        $('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
                                        refreshTable(window.location.href)
                                    }
                                })
                            } else {
                                if ( response.delete == "occupied" ) {
                                    swal("Error","Este registro esta siendo usado, cambie la categoria que esta asignada ene esta ciudad","error")
                                } else {
                                    swal("Ha ocurrido un error","","error")
                                }
                            }
                        }
                    })
                }
            }).catch(swal.noop)

            
            swal({
                title: "¿Realmente desea dar de baja los <span style='color:#F8BB86'>" + ids_array.length + "</span> registros seleccionados?",
                text: "¡Cuidado!",
                html: true,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, continuar",
                showLoaderOnConfirm: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
                closeOnConfirm: false
            },
            function() {
                config = {
                    'route' : route,
                    'ids'   : ids_array,
                }
                ajaxSimple(config);
            });
        }
    });
});
