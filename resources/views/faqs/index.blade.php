@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
th {
    text-align: center!important;
}
textarea {
    resize: none;
}
.table td.text {
    max-width: 177px;
}
.table td.text span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 100%;
}
</style>
<div class="text-center" style="margin: 20px;">
    
    <h2>Lista de {{$title}}</h2>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <a href=""><button type="button" class="btn btn-primary" id="new-row">Agregar noticia</button></a>
                    </div>
                    <div class="grid-body">
                        <div class="table-responsive" id="table-container">
                            @include('faqs.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/validacionesNoticias.js') }}"></script>
<script src="{{ asset('js/noticiasAjax.js') }}"></script> 
<script type="text/javascript">

$('#form_noticia').on('hidden.bs.modal', function (e) {
    $('#form_noticia div.form-group').removeClass('has-error');
    $('#guardar_noticia').show();
})

$('body').delegate('#nueva_noticia','click', function() {
    $("form#noticias").get(0).setAttribute('action', "{{url('/noticias/guardar')}}");
    $('h4#titulo_form_noticias').text('Nueva noticia');
    $("#form_noticia .form-control").val('');
    $("div#foto").hide();
    $('#form_noticia').modal();
});

$('body').delegate('.eliminar_noticia','click', function() {
    var noticia_id = $(this).parent().siblings("td:nth-child(1)").text();
    var token = $("#token").val();
    var id = $(this).parent().parent().attr('id');

    swal({
        title: "¿Realmente desea eliminar la noticia con el id " + "<span style='color:#F8BB86'>" + noticia_id + "</span>?",
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

</script>
@endsection