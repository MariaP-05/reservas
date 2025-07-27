@extends('adminlte::page')

@section('title', 'Lista de Tareas')

@section('content_header')
<h1>Tareas</h1>
@stop

@section('content')
<div class="card">
    <a href="{{ route('admin.tareas.create') }}" title="Crear Nueva Tarea"
        style="position:fixed;	width:60px;	height:60px; top:57px;	right:40px;
               background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
            font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-plus" style="margin-top:16px"></i>
    </a>

      @include('admin.tareas.partials.busqueda')
            <div class="card-body">
                <div class="form-group col-sm-12">
                    <div class="row"> 
                    @include('flash-message')
                <br>
                    </div>
            <table id="tareas" class="table table-striped col-sm-12">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Id</th>
                        <th>Denominacion</th>
                        <th>Fecha</th>
                        <th>Descripcion</th>
                        <th>Prioridad</th>
                        <th>Asignada para:</th>
                        <th>Estado</th>
                
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tareas as $tarea)
                    <tr >
                        <td>{{ $tarea->id }}</td>
                        <td>{{ $tarea->denominacion }}</td>
                        <td>{{ $tarea->fecha}}</td>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->prioridad }}</td>
                        <td>{{isset( $tarea->User) ? $tarea->User->name  : ''}}</td>
                        <td>{{isset( $tarea->Estado_tarea) ? $tarea->Estado_tarea->denominacion  : ''}}</td>
                        

                        <td>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <form method="post" action="{{ route('admin.tareas.destroy', $tarea->id) }}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            title="Eliminar Tarea">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6 form-group">
                                    <form method="get" action="{{ route('admin.tareas.edit', $tarea->id) }}">

                                        <button type="submit" class="btn btn-outline-primary"
                                            title="Editar Tarea">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @stop

    @section('css')

    @stop

    @section('js')

    <script src="{{ asset('admin1/tareas/index.js') }}"></script>

    @stop