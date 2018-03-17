$(function() {
    $('body').delegate('.log-out','click', function() {
        swal({
            title: '¿Desea cerrar la sesión?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                window.location.href = baseUrl.concat('/logout');
            }
        }).catch(swal.noop);
    });

    $('body').delegate('.change-password','click', function() {
        swal({
            title: 'Complete los siguientes campos: ',
            buttons:["Cancelar", "Aceptar"],
            content: {
                element: "form",
                attributes: {
                    innerHTML:
                        "<form>"+
                            "<div class='row'>"+
                                "<div class='col-sm-12 col-xs-12'>"+
                                    "<div class='form-group'>"+
                                        "<label>Contraseña actual</label>"+
                                        "<input type='text' class='form-control pass-font' id='current-password' name='current-password'>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-sm-12 col-xs-12'>"+
                                    "<div class='form-group'>"+
                                        "<label>Nueva contraseña</label>"+
                                        "<input type='text' class='form-control pass-font' id='new-password' name='new-password'>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='col-sm-12 col-xs-12'>"+
                                    "<div class='form-group'>"+
                                        "<label>Confirmar contraseña</label>"+
                                        "<input type='text' class='form-control pass-font' id='confirm-password' name='confirm-password'>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                        "</form>"
                },
            }
        }).then((accept) => {
            if (accept){
                current_pass = $('#current-password').val();
                new_pass = $('#new-password').val();
                confirm_pass = $('#confirm-password').val();

                console.log(current_pass);
                config = {
                    'route'     : 'sa',
                    'ids'       : 'asdasd',
                    'refresh'   : true,
                }
                //console.log(config);
            }
        }).catch(swal.noop);
    });

            function changePassword(id,correo,actualPassword,newPassword,confirmPassword) {
                $.ajax({
                    method: "POST",
                    url: "{{url('/usuarios/sistema/change_password')}}",
                    data:{
                        "user_pass_id":id,
                        "correo":correo,
                        "actualPassword":actualPassword,
                        "newPassword":newPassword,
                        "confirmPassword":confirmPassword,
                    },
                    success: function(data) {
                        $('div#change-pass div.form-group').removeClass('has-error');

                        if (data == 'contra cambiada') {
                            swal({
                                title: "Contraseña modificada con éxito",
                                type: "success",
                                showConfirmButton: true,
                            });
                        } else if (data == 'contra nueva diferentes') {
                            swal({
                                title: "Las contraseñas deben ser iguales, corrijala antes de continuar",
                                type: "error",
                                showConfirmButton: true,
                            });
                            $('div#change-pass input#newPassword, div#change-pass input#confirmPassword').parent().addClass('has-error');
                        } else if (data == 'contra erronea') {
                            swal({
                                title: "Debe proporcionar la contraseña actual para poder cambiarla",
                                type: "error",
                                showConfirmButton: true,
                            });
                            $('div#change-pass input#actualPassword').parent().addClass('has-error');
                        }
                        //$('#guardar-usuario-sistema').show();
                    },
                    error: function(xhr, status, error) {
                        swal({
                            title: "<small>Error!</small>",
                            text: "Ha ocurrido un error mientras se cambiaba la contraseña, porfavor, trate nuevamente.<br><span style='color:#F8BB86'>\nError: " + xhr.status + " (" + error + ") "+"</span>",
                            html: true
                        });
                    }
                });
            }

    
});
