@extends('adminlte::page')
@section('title', 'Pagina Principal')

@section('css')

@stop

@section('content_header')

    <h1>Atención de Turnos</h1>

@stop

@section('content')
    <p>Sistema de Gestión</p>
    
    <a href="{{ route('admin.reservas.create') }}" title="Crear Nuevo Turno"
        style="position:fixed;	width:60px;	height:60px; top:60px;	right:40px;
        background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
        font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-plus" style="margin-top:16px"></i>
    </a>

    <a href="{{ route('admin.clientes.create') }}" title="Crear Nuevo Paciente"
        style="position:fixed;	width:60px;	height:60px; top:130px;	right:40px;
    background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
    font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-user-plus" style="margin-top:16px"></i>
    </a>
  







    @stop

    @section('css')
    @stop


    @section('js')


    @stop
