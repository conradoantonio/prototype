/*Código para validar el formulario de datos del usuario*/
var inputs = [];
var msgError = '';
var regExprTitulo = /^[\* a-z A-Z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,30}$/i;
var regExprContenido = /^[\* a-z A-Z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,140}$/i;
var regExprNum = /^[\d .]{1,}$/i;
$("#guardar_banner").on('click', function() {
    inputs = [];
    msgError = '';

    validarSelect($('select#tipo_banner_id')) == false ? inputs.push('Tipo') : ''
    validarArchivo($('input#foto_banner')) == false ? inputs.push('Imagen banner') : ''

    if (inputs.length == 0) {
        $(this).children('i').show();
        $(this).attr('disabled', true);
        guardarBanner($("#guardar_banner"));
    } else {
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "select#tipo_banner_id" ).change(function() {
    validarSelect($(this));
});

$('input#foto_banner').bind('change', function() {
    if ($(this).val() != '') {

        kilobyte = (this.files[0].size / 1024);
        mb = kilobyte / 1024;

        archivo = $(this).val();
        extension = archivo.split('.').pop().toLowerCase();

        if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
            swal({
                title: "Archivo no válido",
                text: "Debe seleccionar una imágen con formato jpg, jpeg o png, y debe pesar menos de 5MB",
                type: "error",
                closeOnConfirm: false
            });
        }
    }
});

function validarArchivo(campo) {
    archivo = $(campo).val();
    extension = archivo.split('.').pop().toLowerCase();
    if($('form#form_banner input#id').val() != '' && ($(campo).val() == '' || $(campo).val() == null)) {
        return true;
    } else if ($.inArray(extension, fileExtension) == -1 || mb >= 5) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

function validarInput (campo,regExpr) {
    if (!$(campo).val().match(regExpr)) {
        $(campo).parent().addClass("has-error");
        msgError = msgError + $(campo).parent().children('label').text() + '\n';
        return false;
    } else {
        $(campo).parent().removeClass("has-error");
        return true;
    }
}

function validarSelect (select) {
    if ($(select).val() == '0' || $(select).val() == '' || $(select).val() == null) {
        if ($(select).hasClass('select2')) {
            $(select).parent().children('div.select2').children('ul.select2-choices').addClass("select-error");
        } else {
            $(select).parent().addClass("has-error");
        }
        msgError = msgError + $(select).parent().children('label').text() + '\n';
        return false;
    } else {
        if ($(select).hasClass('select2')) {
            $(select).parent().children('div.select2').children('ul.select2-choices').removeClass("select-error");
        } else {
            $(select).parent().removeClass("has-error");
        }
        return true;
    }
}

/*Fin del código para validar el archivo que importa datos desde excel*/