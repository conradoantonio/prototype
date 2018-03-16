@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<div class="text-center" style="margin: 20px;">
    <h2>{{$faq ? 'Editar' : 'Nueva'}} pregunta frecuente</h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple form-container" style="display: none">
                <div class="grid-title">
                    <div class="grid-body">
                        <h3>Datos</h3>
                    	<div class="container-fluid content-body">
                            <form id="form-data" action="{{url('admin/faqs')}}/{{ $faq ? 'update' : 'save' }}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="0" data-redirect="1" data-table_id="example3" data-container_id="table_container">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 hide">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control" value="{{$faq ? $faq->id : ''}}" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="question">Pregunta</label>
                                            <input type="text" class="form-control not-empty" value="{{$faq ? $faq->question : ''}}" id="question" name="question" data-msg="Pregunta" placeholder="Pregunta">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="answer">Respuesta</label>
                                            <textarea class="form-control not-empty" id="answer" name="answer" data-msg="Respuesta" placeholder="Respuesta...">{{$faq ? $faq->answer : ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="imagenes">
                                                Imágen
                                                @if($faq)
                                                    <a class="document-read" href="{{url($faq->img)}}" data-lightbox='preview' data-title='Imágen'>Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                @endif
                                            </label>
                                            <input type="file" class="form-control file image {{$faq ? '' : 'not-empty'}}" id="img" name="img" data-msg="Imagen">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('admin/faqs')}}"><button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button></a>
                                <button type="submit" class="btn btn-primary save">Guardar</button>
                            </form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection