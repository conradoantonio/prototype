<form id="form_notificaciones_generales" action="{{url('admin/notificaciones/send-notification')}}" onsubmit="return false" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-refresh="0" data-redirect="0">
    <div class="row">
    	<div class="col-sm-6 col-xs-12">
            <div class="form-group">
	        	<label for="type">Tipo notificación</label>
				<select name="type" id="type" name="type" class="form-control not-empty" data-msg="Tipo notificación" style="width: 100%">
					<option value="0" selected>Seleccionar una opción</option>
					<option value="1">General</option>
					<option value="2">Individual</option>
				</select>
			</div>
		</div>
    	<div class="col-sm-6 col-xs-12">
            <div class="form-group">
	        	<label for="application">Aplicación</label>
				<select name="application" id="application" name="application" class="form-control not-empty" data-msg="Aplicación" style="width: 100%">
					<option value="0" selected>Seleccionar aplicación</option>
					<option value="1">Cliente</option>
					<option value="2">Repartidor</option>
				</select>
			</div>
		</div>
    	<div class="col-sm-6 col-xs-12 clockpicker">
            <div class="form-group">
                <label for="time">Hora</label>
                <input type="text" class="form-control timepicker" id="time" name="time" placeholder="Ej. 08:30">
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="date">Fecha</label>
                <input type="text" name="date" class='form-control date-picker' id='date' placeholder="Ej. 2020-12-27">
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control not-empty" id="title" maxlength="30" name="title" data-msg="Título" placeholder="Describa en menos de 30 caracteres el título de la notificación">
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="content">Contenido del mensaje</label>
				<textarea class="form-control not-empty" id="content" name="content" maxlength="140" data-msg="Contenido del mensaje" placeholder="Describa en menos de 140 caracteres el contenido de la notificación" rows="3">{{ isset($datos) ? $datos->direccion : "" }}</textarea>    
            </div>
        </div>
        <div class="col-md-12 users-content" style="display:none;"">
            <div class="form-group">
                <label for="users_id">Usuarios</label>
				<select name="users_id[]" id="users_id" class="select2" multiple="multiple" data-msg="Usuarios" style="width: 100%">
					<option value="0" disabled>Seleccionar usuarios</option>
				</select>
			</div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary save">Enviar</button>
</form>