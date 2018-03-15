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
    
    <h2>Lista de preguntas frecuentes</h2>

    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple">
                <div class="grid-title">
                    <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                    <div>
                        <a href="{{url('admin/faqs/form')}}"><button type="button" class="btn btn-primary new-row"><i class="fa fa-plus"></i> Agregar</button></a>
                        <button type="button" class="btn btn-danger delete-rows" data-url="{{url("admin/$menu/delete")}}"><i class="fa fa-trash"></i> Eliminar</button>
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
<script src="{{ asset('js/validFunctions.js') }}"></script>
<script src="{{ asset('js/generalAjax.js') }}"></script>
<script src="{{ asset('js/globalFunctions.js') }}"></script>
<script type="text/javascript">



</script>
@endsection