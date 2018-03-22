@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
    <div class="text-center" style="margin: 20px;">
        
        <h2>Lista de noticias</h2>

        <div class="row-fluid" style="display: none">
            <div class="span12">
                <div class="grid simple">
                    <div class="grid-title">
                        <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                        <div class="general-info" data-url="{{url("admin/noticias/delete")}}" data-refresh="0">
                            <a href="{{url('admin/noticias/form')}}"><button type="button" class="btn btn-primary new-row"><i class="fa fa-plus"></i> Agregar</button></a>
                            <button type="button" class="btn btn-danger delete-rows" disabled="disabled"><i class="fa fa-trash"></i> Eliminar</button>
                        </div>
                        <div class="grid-body">
                            <div class="table-responsive" id="table-container">
                                @include('news.table')
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
    <script src="{{ asset('js/dataTables.js') }}"></script>
@endsection