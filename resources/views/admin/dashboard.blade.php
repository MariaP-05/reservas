@extends('adminlte::page')
@section('title', 'Pagina Principal')

@section('css')

@stop

@section('content_header')
    <h1>Veiga Córdoba Seguros</h1>
@stop

@section('content')
    <p>Bienvenidos</p>


    <a href="{{ route('admin.polizas.create') }}" title="Crear Nueva Poliza"
        style="position:fixed;	width:60px;	height:60px; top:60px;	right:40px;
background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-folder" style="margin-top:16px"></i>
    </a>

    <a href="{{ route('admin.clientes.create') }}" title="Crear Nuevo Cliente"
        style="position:fixed;	width:60px;	height:60px; top:130px;	right:40px;
background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-user-plus" style="margin-top:16px"></i>
    </a>

    <div class="row">
        <div class=" col-lg-12 col-md-12 col-xs-12">
            <marquee direction="up" behavior="alternate" loop="6">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><a target="_blank" class="info-box-icon btn-warning"
                            style="width: 50px;  height: 50px; border-radius: 50%;"
                            href="{{ url('admin/polizas?vig_hasta=' . $fecha_quince->format('d-m-Y') . '&id_estado_polizas=1') }}"
                            title="Lista de Polizas a Vencer">
                            <i class="fa fa-exclamation" style="color:#FFF"></i></a>
                    </span>
                    <div class="info-box-content" style="color:#FFF">
                        <span class="info-box-number">Polizas a Vencer</span>
                        <span class="myDIV info-box-text">Cantidad: {{ $cantidad_xvencer }}</span>

                    </div>
                </div>
            </marquee>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-xs-12">
            <marquee direction="up" behavior="alternate" loop="6">
                <div class="info-box bg-green ">
                    <span class="info-box-icon"><a target="_blank" class="info-box-icon btn-success"
                            style="width: 50px;  height: 50px; border-radius: 50%;"
                            href="{{ url('admin/polizas?vig_desde=' . $fecha_mes->format('d-m-Y') . '&id_estado_polizas=1') }}"
                            title="Lista de Polizas Vigentes">

                            <i class="fa fa-check-square"></i></a>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-number">Polizas Vigentes</span>
                        <span class="myDIV info-box-text"> Cantidad: {{ $cantidad_vigentes }}</span>
                        <span class="info-box-text">Desde el {{ $fecha_mes->format('d-m-Y') }}</span>
                    </div>
                </div>
            </marquee>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
            <marquee direction="up" behavior="alternate" loop="6">
                <div class="info-box bg-red ">
                    <span class="info-box-icon"><a target="_blank" class="info-box-icon btn-danger"
                            style="width: 50px;  height: 50px; border-radius: 50%;"
                            href="{{ url('admin/polizas?vig_desde=' . $fecha_mes->format('d-m-Y') . '&id_estado_polizas=2') }}"
                            title="Lista de Polizas Canceladas">
                            <i class="fa fa-window-close"></i></a>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-number">Polizas Canceladas</span>
                        <span class="myDIV info-box-text">Cantidad: {{ $cantidad_canceladas }}</span>
                        <span class="info-box-text">Desde el {{ $fecha_mes->format('d-m-Y') }}</span>
                    </div>
                </div>
            </marquee>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12">
            <marquee direction="up" behavior="alternate" loop="6">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><a target="_blank" class="info-box-icon btn-primary"
                            style="width: 50px;  height: 50px; border-radius: 50%;"
                            href="{{ url('admin/polizas?vig_desde=' . $fecha_mes->format('d-m-Y') . '&id_estado_polizas=3') }}"
                            title="Lista de Polizas Renovadas">
                            <i class="fa fa-undo"></i></a>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-number">Polizas Renovadas</span>
                        <span class="myDIV info-box-text">Cantidad: {{ $cantidad_renovadas }}</span>
                        <span class="info-box-text">Desde el {{ $fecha_mes->format('d-m-Y') }}</span>
                    </div>
                </div>
            </marquee>
        </div>


        <div class="col-lg-3 col-md-6 col-xs-12">
            <marquee direction="up" behavior="alternate" loop="6">
                <div class="info-box bg-secondary">
                    <span class="info-box-icon"><a target="_blank" class="info-box-icon btn-secondary"
                            style="width: 50px;  height: 50px; border-radius: 50%;"
                            href="{{ url('admin/polizas?vig_desde=' . $fecha_mes->format('d-m-Y') . '&id_estado_polizas=4') }}"
                            title="Lista de Polizas Vencidas">
                            <i class="fa fa-ban" style="color:#FFF"></i></a>
                    </span>
                    <div class="info-box-content" style="color:#FFF">
                        <span class="info-box-number">Polizas Vencidas</span>
                        <span class="myDIV info-box-text">Cantidad: {{ $cantidad_vencidas }}</span>
                        <span class="info-box-text">Desde el {{ $fecha_mes->format('d-m-Y') }}</span>
                    </div>
                </div>
            </marquee>
        </div>
    </div>

@stop

@section('css')
@stop


@section('js')


@stop
