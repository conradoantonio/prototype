@extends('layouts.main')

@section('content')
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
<div class="content">
    <div class="page-title text-center">
        <h3>Dashboard </h3>
    </div>

    <div class="row" id="data_user_admin">
        <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom text-left">
            <div class="tiles blue added-margin">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class=""></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title"> Total de servicios </div>
                    <div class="heading"> <span class="animate-number" data-value="50" data-animation-duration="1000">0</span> </div>
                    <div class="progress transparent progress-small no-radius">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%" ></div>
                    </div>
                    <div class="description"><span class="text-white mini-description ">Hechas desde la app</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom text-left">
            <div class="tiles green added-margin">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class=""></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title"> Total de usuarios </div>
                    <div class="heading"> <span class="animate-number" data-value="60" data-animation-duration="1200">0</span> </div>
                    <div class="progress transparent progress-small no-radius">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%"></div>
                    </div>
                    <div class="description"><span class="text-white mini-description ">Registrados en la aplicación</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 spacing-bottom text-left">
            <div class="tiles red added-margin">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class=""></a> <a href="javascript:;" class="remove"></a> </div>
                    <div class="tiles-title"> Usuarios bloqueados </div>
                    <div class="heading"> <span class="animate-number" data-value="5" data-animation-duration="1200">0</span> </div>
                    <div class="progress transparent progress-white progress-small no-radius">
                        <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="" ></div>
                    </div>
                    <div class="description"><span class="text-white mini-description ">2% usuarios totales (app) </span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="tiles purple added-margin">
                <div class="tiles-body">
                    <div class="controller"> <a href="javascript:;" class=""></a> <a href="javascript:;" class="remove"></a> </div>
                        <div class="tiles-title"> Ganancia total </div>
                        <div class="row-fluid">
                        <div class="heading">$<span class="animate-number" data-value="4000" data-animation-duration="700">0</span> </div>
                        <div class="progress transparent progress-white progress-small no-radius">
                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%"></div>
                        </div>
                    </div>
                    <div class="description"><span class="text-white mini-description ">A través de la app</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="text-center col-sm-12 col-xs-12"><!-- Se imprime con todo el ancho de la página -->
            <canvas id="myChart" height="200" width="700"></canvas>  
        </div>
    </div>
</div>
<script type="text/javascript">

</script>
@endsection