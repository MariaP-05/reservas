@extends('adminlte::page')

@section('title', 'Lista de Tipos de Turnos')

@section('content_header')
    <h1>Tipos de Turnos</h1>
@stop

@section('content')
    <div class="card">
        <a href="{{ route('admin.tipos_turno.create') }}" title="Crear Nuevo Tipo de Turno"
            style="position:fixed;	width:60px;	height:60px; top:57px;	right:40px;
    background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
    font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
            target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
            onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
            <i class="fa fa-plus" style="margin-top:16px"></i>
        </a>
        <div class="cadr-body">
            <div class="form-group col-sm-12">
                <div class="row">
                    <br>
                </div>
                <table id="tipos_turno" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Denominación</th>
                            <th>Color</th>
                            <th>Alerta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipos_turno as $tipos_turno)
                            <tr>
                                <td>{{ $tipos_turno->id }}</td>
                                <td>{{ $tipos_turno->denominacion }}</td>
                                <td><input id="color" name="color" type="color"
                                        value={{ isset($tipos_turno->color) ? $tipos_turno->color : '#ff0000' }}
                                        @disabled(true) /></td>
                                <td>{{$tipos_turno->alerta}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <form method="post"
                                                action="{{ route('admin.tipos_turno.destroy', $tipos_turno->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar Tipo de Turno">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <form method="get"
                                                action="{{ route('admin.tipos_turno.edit', $tipos_turno->id) }}">
                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Tipo de Turno">
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
    <script src="{{ asset('admin1/tipos_turno/index.js') }}"></script>

    @stop
