/*Código para validar el formulario de datos del usuario*/
mb = 0;
fileExtension = ['jpg', 'jpeg', 'png'];
var inputs = [];
var msgError = '';
var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
var btn = $(".guardar-form");
btn.on('click', function() {
    inputs = [];
    msgError = '';

    validarInput($('input#calle'), regExprTexto) == false ? inputs.push('Calle') : ''
    validarInput($('input#colonia'), regExprTexto) == false ? inputs.push('Colonia') : ''
    validarInput($('input#num_ext'), regExprTexto) == false ? inputs.push('Número exterior') : ''
    //validarInput($('input#num_int'), regExprTexto) == false ? inputs.push('Número interior') : ''
    validarInput($('input#codigo_postal'), regExprTexto) == false ? inputs.push('Código postal') : ''
    validarInput($('input#estado'), regExprTexto) == false ? inputs.push('Estado') : ''
    validarInput($('input#ciudad'), regExprTexto) == false ? inputs.push('Ciudad') : ''

    if (inputs.length == 0) {
        btn.addClass('hide');
        btn.submit();
    } else {
        swal("Corrija los siguientes campos para continuar: ", msgError);
        return false;
    }
});

$( "input#calle" ).blur(function() { validarInput($(this), regExprTexto); });
$( "input#colonia" ).blur(function() { validarInput($(this), regExprTexto); });
$( "input#num_ext" ).blur(function() { validarInput($(this), regExprTexto); });
//$( "input#num_int" ).blur(function() { validarInput($(this), regExprTexto); });
$( "input#codigo_postal" ).blur(function() { validarInput($(this), regExprTexto); });
$( "input#estado" ).blur(function() { validarInput($(this), regExprTexto); });
$( "input#ciudad" ).blur(function() { validarInput($(this), regExprTexto); });


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
/*Fin de código para validar el formulario de datos del usuario*/