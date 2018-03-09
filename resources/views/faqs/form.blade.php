@extends('admin.main')
@section('content')
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style type="text/css">
    textarea {
        resize: none;
    }
    .select-error{
        border-color: #A94442!important;
        border-style: solid!important;
        border-width: 1px!important;
    }
</style>
<div class="text-center" style="margin: 20px;">
    <h2>{{$slider ? 'Editar' : 'Nuevo'}} slider</h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple" style="display: none" id="form-container">
                <div class="grid-title">
                    <div class="grid-body">
                        <h3>Datos</h3>
                    	<div class="container-fluid content-body">
                            <form id="form-data" action="{{url('sliders')}}/{{ $slider ? 'editar' : 'guardar' }}" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 hidden">
                                        <div class="form-group">
                                            <label for="id">ID</label>
                                            <input type="text" class="form-control" value="{{$slider ? $slider->id : ''}}" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="subcatalog_id">Subcatálogo</label>
                                            <select class="select2" id="subcatalog_id" name="subcatalog_id" style="width: 100%;">
                                                <option value="0" disabled selected>Seleccione una opción</option>
                                                @foreach($catalogs as $catalog)
                                                    @if($slider)
                                                        <optgroup label="{{$catalog->title}}">
                                                            @foreach($subcatalogs as $subcatalog)
                                                                @if($subcatalog->catalog_id == $catalog->id)
                                                                    <option value="{{$subcatalog->id}}" {{$slider->subcatalog_id == $subcatalog->id ? 'selected' : ''}}>{{$subcatalog->title}}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @else
                                                        <optgroup label="{{$catalog->title}}">
                                                            @foreach($subcatalogs as $subcatalog)
                                                                @if($subcatalog->catalog_id == $catalog->id)
                                                                    <option value="{{$subcatalog->id}}">{{$subcatalog->title}}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control" value="{{$slider ? $slider->name : ''}}" id="name" name="name" placeholder="Nombre imágen">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="msg">Mensaje</label>
                                            <textarea class="form-control not-empty" id="msg" name="msg" data-name="Mensaje" placeholder="Mensaje...">{{$slider ? $slider->msg : ''}}</textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="imágenes">
                                                Imágen (Móvil)
                                                @if($slider)
                                                    <a class="document-read" href="{{url($slider->img_movil)}}" data-lightbox='preview' data-title='Imágen'>Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                @endif
                                            </label>
                                            <input type="file" class="form-control" id="img_movil" name="img_movil">
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="imágenes">
                                                Imágen
                                                @if($slider)
                                                    <a class="document-read" href="{{url($slider->img_web)}}" data-lightbox='preview' data-title='Imágen'>Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                                                @endif
                                            </label>
                                            <input type="file" class="form-control" id="img_web" name="img_web">
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('sliders')}}"><button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button></a>
                                <button type="submit" class="btn btn-primary guardar-form">
                                    <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Guardar
                                </button>
                            </form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/validacionesSlider.js') }}"></script>
<script src="{{ asset('js/generalAjax.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $(".select2").select2();

        setTimeout(function() {
            $('div#form-container').fadeIn('low');
        }, 500)
    })
</script>
@endsection