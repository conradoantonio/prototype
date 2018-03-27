@extends('layouts.main')

@section('content')
<style type="text/css">
	textarea{
		resize: none;
		overflow: hidden;
	}
	ul.select-error{
		border: 1px #a94442 solid!important;
	}
</style>
<link rel="stylesheet" href="{{ asset('plugins/boostrap-clockpicker/bootstrap-clockpicker.min.css')}}"  type="text/css" media="screen"/>
<div class="text-center" style="margin: 20px;">
	<h2>Notificaciones app</h2>
	<div class="row-fluid">
        <div class="span12">
            <div class="grid simple form-container" style="display: none">
                <div class="grid-title">
                    <div class="grid-body">
                    	<div class="row">
	                    	<div class="col-sm-12 col-xs-12">
					            <div class="alert alert-info alert-dismissible text-left" role="alert">
							        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
							        <strong>Nota: </strong><br>
							        - Complete los campos llamados fecha y hora para programar el momento en que debe enviarse la notificación.<br>
							        - No se pueden programar notificaciones para ser enviadas en fechas u horarios que ya pasaron.<br>
							        - En caso de querer envíar la notificación inmediatamente, deje los campos de fecha y hora vacíos.<br>
							        - Las notificaciones no pueden ser canceladas una vez sean programadas.<br>
							    </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
						        @include('notifications.form')
						    </div>
						</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset('js/tabs_accordian.js') }}"></script>
<script type="text/javascript">
	$(function() {
	    $('.date-picker').datepicker('setStartDate', "{{$start_date}}");
	});

	$( "select#type, select#application" ).change(function() {
		type = $('select#type').val();
		app = $('select#application').val();
		select = $('select#users_id');
		options = null;
		
		if (type == 2) {//Individual notification
			if (app != 0) {//App was selected
				$('.users-content').show('300');
				$('select#users_id').addClass('not-empty');
				if (app == 1) {//
					options = <?php echo $customers;?>;
			    } else if (app == 2) {
					options = <?php echo $deliverers;?>;
			    }
			} else {
				$('.users-content').hide('300');
				$('select#users_id').removeClass('not-empty');
			}
		} else {
			$('.users-content').hide('300');
				$('select#users_id').removeClass('not-empty');
		}
		
		select.children().remove();

	    if (options) {
    		select.append("<option value='0' disabled>Seleccione usuarios</option>");
															
	    	options.forEach( function (opt) {
	    		select.append("<option value="+ opt.id +">"+ opt.name + ' '+ opt.lastname +"</option>");
			});
	    }
	});
</script>
@endsection