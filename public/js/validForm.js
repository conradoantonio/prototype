/*
* Script de validaciones de un formulario
* Luis Castañeda
* v 2.3
*/
var re_email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
var re_num_dec = /^[0-9]+([.][0-9]{1,2})?$/
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$('.numeric').keypress(function(e) {
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		return false;
	}
});

$('.character').keypress(function(e) {
	if (e.which > 48 && e.which < 57) {
		return false;
	}
});

$('.length').keyup(function(){
	$(this).siblings('span.display-counter').find('span').text( $(this).val().length )
})

$('.min-date').blur(function() {
	var actual = new Date();
	if ( (parseInt(actual.getFullYear()) - parseInt($(this).val()) ) < parseInt($(this).data('min-date')) ){
		$(this).parent().removeClass('has-error')
	} else {
		$(this).parent().addClass('has-error')
	}
});

$(".not-empty").blur(function() {
	if ( !$(this).parent().hasClass('has-error') ){
		if ( $(this).val() || $(this).val()  != 0 ){
			$(this).parent().removeClass('has-error')
		} else {
			$(this).parent().addClass('has-error')
		}
	} else {
		if ( $(this).val() || $(this).val()  != 0 ){
			$(this).parent().removeClass('has-error')
		} else {
			$(this).parent().addClass('has-error')
		}
	}
});

$(".between-val").blur(function(){
	if ( $(this).val() >= $(this).data('min') && $(this).val() <= $(this).data('max') ){
		$(this).parent().removeClass('has-error')
		$('.accept').removeClass('disabled').attr('disabled',false)
	} else {
		$(this).parent().addClass('has-error')
		$('.accept').addClass('disabled').attr('disabled',true)
	}
})

$('.length').blur(function(){
	if ( $(this).val().length <= $(this).data('min') ){
		$(this).parent().removeClass('has-error')
	} else {
		$(this).parent().addClass('has-error')
	}
	if ( $(this).val().length >= $(this).data('max') ){
		$(this).parent().removeClass('has-error')
	} else {
		$(this).parent().addClass('has-error')
	}
	if ( $(this).val().length == $(this).data('equal') ){
		$(this).parent().removeClass('has-error')
	} else {
		$(this).parent().addClass('has-error')
	}
})

$(".email").blur(function() {
	if(!$(this).val().match(re_email)) {
		if ( !$(this).parent().hasClass("has-error") ){
			$(this).parent().addClass('has-error')
		}
	} else {
		$(this).parent().removeClass('has-error')
	}
});

$(".decimal").blur(function() {
	if(!$(this).val().match(re_num_dec)) {
		if ( !$(this).parent().hasClass("has-error") ){
			$(this).parent().addClass('has-error')
		}
	} else {
		$(this).parent().removeClass('has-error')
	}
});

$(".guardar").on('click',function(e){
	e.preventDefault();
	var btn = $(this);
	var errors_count = 0;
	var msg = "";
	var fileExtension = ['jpg','jpeg','png','gif'];
	var pdfExtension = ['pdf'];
	var excelExtension = ['xls','xlsx'];
	var wordtension = ['docx'];
	var mb = 0;
	var kilobyte = 0;
	var actual = new Date();

	btn.prop('disabled',true).addClass('disabled');
	$('form#'+$(this).data('target')).find('input, select, textarea').each(function(i,e){
		if ( $(this).hasClass('not-empty') ) {
			if ( $(this).is(':checkbox') ){
				if ( !$(this).is(':checked') ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Campo vacio</li>";
				}
			}

			if ( !$(this).val() || $(this).val() == 0 ){
				$(this).parent().addClass('has-error')
				errors_count += 1;
				msg = msg +"<li>"+$(this).data('name')+": Campo vacio</li>";
			} else {
				$(this).parent().removeClass('has-error')
			}
		}

		if ( $(this).hasClass('length') ) {
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).data('min') ){
					if ( $(this).val().length <= $(this).data('min') ){
						$(this).parent().removeClass('has-error')
					} else {
						errors_count += 1;
						msg = msg +"<li>"+$(this).data('name')+": Mínimo de "+$(this).data('min')+" caracteres</li>";
						$(this).parent().addClass('has-error')
					}
				}
			}
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).data('max') ){
					if ( $(this).val().length >= $(this).data('max') ){
						$(this).parent().removeClass('has-error')
					} else {
						errors_count += 1;
						msg = msg +"<li>"+$(this).data('name')+": Máximo de "+$(this).data('max')+" caracteres</li>";
						$(this).parent().addClass('has-error')
					}
				}
			}
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).data('equal') ){
					if ( $(this).val().length == $(this).data('equal') ){
						$(this).parent().removeClass('has-error')
					} else {
						errors_count += 1;
						msg = msg +"<li>"+$(this).data('name')+": Total de "+$(this).data('equal')+" caracteres</li>";
						$(this).parent().addClass('has-error')
					}
				}
			}
		}

		if ( $(this).hasClass('between-val') ) {
			if ( !$(this).parent().hasClass("has-error") ){
				if ( $(this).val() >= $(this).data('min') && $(this).val() <= $(this).data('max') ){
					$(this).parent().removeClass('has-error')
				} else {
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": El valor no esta dentro del rango especificado</li>";
				}
			} else {
				$(this).parent().removeClass('has-error')
			}

		}

		if ( $(this).hasClass('email') ) {
			if(!$(this).val().match(re_email)) {
				if ( !$(this).parent().hasClass("has-error") ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Correo inválido</li>";
				}
			}
		}

		if ( $(this).hasClass('decimal') ) {
			if(!$(this).val().match(re_num_dec)) {
				if ( !$(this).parent().hasClass("has-error") ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Correo inválido</li>";
				}
			}
		}

		if ( $(this).hasClass('min-date') ){
			if ( (parseInt(actual.getFullYear()) - parseInt($(this).val()) ) < parseInt($(this).data('min-date')) ){
				$(this).parent().removeClass('has-error')
			} else {
				if ( !$(this).parent().hasClass('has-error') ){
					$(this).parent().addClass('has-error')
					errors_count += 1;
					msg = msg +"<li>"+$(this).data('name')+": Menos de 10 años de antigüedad</li>";
				}
			}
		}

		if ( $(this).hasClass('file') ){
			archivo = $(this).val();
			extension = archivo.split('.').pop().toLowerCase();
			var allowedExtensions = [];

			if ( $(this).hasClass('image') ){
				allowedExtensions = $.merge(allowedExtensions, fileExtension)
			}

			if ( $(this).hasClass('excel') ){
				allowedExtensions = $.merge(allowedExtensions, excelExtension)
			}

			if ( $(this).hasClass('word') ){
				allowedExtensions = $.merge(allowedExtensions, wordtension)
			}

			if ( $(this).hasClass('pdf') ){
				allowedExtensions = $.merge(allowedExtensions, pdfExtension)
			}

			if ( $(this).val() ) {
				if ( !$(this).parent().hasClass("has-error") ){
					kilobyte = ( $(this)[0].files[0].size / 1024 );
					mb = kilobyte / 1024;

					if ($.inArray(extension, allowedExtensions) == -1 || mb > 3) {
						if ( !$(this).parent().hasClass("has-error") ){
							if ( $.inArray(extension, allowedExtensions) == -1 ) {
								type_error = "Extensiones permitidas: "+allowedExtensions;
							} else {
								type_error = "El arhivo debe ser menor a 3 mb";
							}
							$(this).parent().addClass("has-error");
							errors_count += 1;
							msg = msg +"<li>"+$(this).data('name')+": "+type_error+"</li>";
						}
					} else {
						$(this).parent().removeClass("has-error");
					}
				}
			}
		}
	})

	if ( errors_count > 0 ) {
		swal({
			title: 'Corrija los siguientes campos para continuar: ',
			type: 'error',
			text: "<ul id='errores_list'>"+msg+"</ul>",
			html:true,
			showCloseButton: true,
			confirmButtonText: 'Aceptar',
		});
		$(".guardar").prop( "disabled", false ).removeClass('disabled');
	} else {
		swal({
			title: 'Guardando',
			text: "<div><i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i></div>",
			html: true,
			showConfirmButton: false
		});

		if ( $('form#'+btn.data('target')).hasClass('ajax') ) {
			$.ajax({
				url:$("form#"+btn.data('target')).attr('action'),
				type:$("form#"+btn.data('target')).attr('method'),
				data:new FormData($("form#"+btn.data('target'))[0]),
				processData: false,
				contentType: false,
				success:function(response) {
					$(".guardar").prop( "disabled", false ).removeClass('disabled');;
					if (response.save) {
						swal(response.msg,"","success");
						refreshTable(window.location.href);
						$('.modal').modal('hide')
					} else {
						swal(response.msg,"","error");
						btn.prop('disabled',false).removeClass('disabled');
					}
				}, error: function(response) {
					swal('Ha ocurrido un error', 'error', 'error');
				}
			})
		} else {
			$('form#'+btn.data('target')).submit();
		}
		return true;
	}
})

/*
* En este evento se limpia la información del formulario
*/
$("#limpiar").on('click',function(){
	clean($('form.valid'))
})

$('.modal').on('hidden.bs.modal', function (e) {
	clean($(this))
})

function clean(ele){
	ele.find('form').find('input.form-control, textarea.form-control').val(null).parent().removeClass('has-error')
	$('form#'+$(this).data('target')+' select').val(0);
	$('form#'+$(this).data('target')+' select').parent().removeClass('has-error');
	$('form#'+$(this).data('target')).select2("val", 0);
}