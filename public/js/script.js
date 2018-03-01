$(function(){
	createTable();

	$('.length').each(function(){
		$(this).siblings('span.display-counter').find('span').text( $(this).val().length )
	})
})

$(document).delegate('.delete_row','click',function(e){
	var ele = $(this);
	e.preventDefault()

	swal({
		title: "¿Quieres eliminar este registro?",
		text: "¡Esta acción no podrá deshacerse!",
		html: false,
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
		$.ajax({
			url: ele.attr('href'),
			method: "DELETE",
			type: "DELETE",
			success:function(response){
				if (response.delete == "true"){
					swal({
						title: "Registro eliminado exitosamente",
						type: "success",
					},
					function() {
						if( ele.hasClass('inner_table') ){
							blockUI($('.show-content'));
							$('#tabla-subcategorias').load(ele.data('url'), function() {
								unblockUI($('.show-content'));
							});
						} else {
							refreshTable(window.location.href)
						}
					});
				} else {
					if ( response.delete == "occupied" ) {
						swal("Error","Este registro esta siendo usado, cambie la categoria que esta asignada ene esta ciudad","error")
					} else {
						swal("Ha ocurrido un error","","error")
					}
				}
			}
		})
	});
})

$(document).delegate('#checkboxParent', "click", function(){
	var checked = false;
	if ( $(this).attr('checked') ) {
		checked = true;
	}
	$(".multiple-delete").each(function(){
		$(this).attr('checked', checked);
	})

	if ( $('.multiple-delete:checked').length ) {
		$('.multiple-delete-btn').attr('disabled', false).removeClass('disabled');
	} else {
		$('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
	}
})

$(document).delegate('.multiple-delete','click',function(){
	if ( $('.multiple-delete:checked').length ) {
		$('.multiple-delete-btn').attr('disabled', false).removeClass('disabled');
	} else {
		$('.multiple-delete-btn').attr('disabled', true).addClass('disabled');
	}

	if ( $('.multiple-delete:checked').length == $('.multiple-delete').length ){
		$("#checkboxParent").attr('checked', true);
	} else {
		$("#checkboxParent").attr('checked', false);
	}
})

$('.multiple-delete-btn').on('click', function(e){
	e.preventDefault();
	var url = $(this).attr('href')
	var ids = [];
	$('.multiple-delete:checked').each(function(){
		ids.push($(this).val());
	})
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
})

$("#filtrar").on('click',function(){
	url = "";
	if ( $("#byPartner").length ){
		if ( $("#byPartner").val() != 0 ){
			url = "/"+$("#byPartner").val();
		} else {
			url = "/0"
		}
	} else {
			url = "/0"
	}


	if ( $("#start_date").val() != "" ){
		var date = new Date($("#start_date").val());
		var start = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' +  date.getDate();
		url = url+'/'+start;
	} else {
		url = url+'/0';
	}

	if ( $("#end_date").val() != "" ){
		var date = new Date($("#end_date").val());
		var end = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' +  date.getDate()
		url = url+'/'+end;
	} else {
		url = url+'/0';
	}
	refreshTable($(this).data('url') +url)
})

$("#exportar").on('click',function(){
	url = "";
	if ( $("#byPartner").length )  {
		if ( $("#byPartner").val() != 0 ){
			url = "/"+$("#byPartner").val();
		} else {
			url = "/0"
		}
	} else {
			url = "/0"
	}

	if ( $("#start_date").val() != "" ){
		var date = new Date($("#start_date").val());
		var start = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' +  date.getDate();
		url = url+'/'+start;
	} else {
		url = url+'/0';
	}

	if ( $("#end_date").val() != "" ){
		var date = new Date($("#end_date").val());
		var end = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' +  date.getDate()
		url = url+'/'+end;
	} else {
		url = url+'/0';
	}
	window.location = $(this).data('url') +url;
})

function refreshTable(url){
	var table = $(".datatable").dataTable();
	$('#body-content').fadeOut();
	$('#body-content').empty();
	table.fnDestroy();
	$('#body-content').load(url, function() {
		$('#body-content').fadeIn();
		createTable()
		checkProgress();
	});
}

$(document).delegate(".change_status",'click',function(e){
	e.preventDefault()
	var ele = $(this);
	var status = ele.is(':checked')?"marcar":"desmarcar";

	swal({
		title: '¿Quieres '+status+' este registro?',
		icon: 'warning',
		buttons:true
	}).then((accept) => {
		if (accept) {
			$.ajax({
				url: ele.data('url'),
				method: "PUT",
				success:function(response){
					if (response.save){
						swal({
							title: 'Registro cambiado exitosamente',
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Ok',
							cancelButtonText: 'Cancelar'
						}).then(function () {
							if ( status == "marcar" ) {
								ele.attr('checked',true)
							} else {
								ele.attr('checked',false)
							}
							checkProgress();
						})
					} else {
						swal("Ha ocurrido un error","","error")
					}
				}
			})
		}
	}).catch(swal.noop)
})

function checkProgress(){
	var progress = 0;
	var total = 0;
	var checked = 0;
	$("tbody tr").each(function(){
		var check = $(this).find('.change_status')

		if ( check.is(':checked') ){
			total += 1;
			checked += 1;
		} else {
			total += 1;
		}

	})
	if (checked != 0){
		progress = checked*100/total;
	} else {
		progress = 0;
	}
	$("#progress_checklist").css('width',progress+"%")
	$("#porcentaje").text(parseFloat(progress).toFixed(0)+"% de mis tareas completadas")
}

function createTable(){
	$(".datatable").dataTable({
		"aaSorting": [[ 0, "desc" ]],
		"oLanguage": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "_MENU_",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún registro disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});
}