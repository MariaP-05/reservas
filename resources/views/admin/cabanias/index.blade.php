@extends('adminlte::page')

@section('title', 'Lista de Cabañas')

@section('content_header')
    <h1>Cabañas</h1>
@stop

@section('content')
    <div class="card">
        <a href="{{ route('admin.cabanias.create') }}" title="Crear Nueva Cabaña"
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
                <table id="cabanias" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Denominación</th>
                            <th>Capacidad</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cabanias as $cabania)
                            <tr>
                                <td>{{ $cabania->id }}</td>
                                <td>{{ $cabania->denominacion }}</td>
                                <td>{{ $cabania->capacidad }}</td>
                                <td>{{ $cabania->observaciones}}</td>
                                <td>
                                    <div class="row">
                                    <div class="col-md-4 form-group">
                                            <form method="post"
                                                action="{{ route('admin.cabanias.destroy', $cabania->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar Cabaña">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <form method="get"
                                                action="{{ route('admin.cabanias.edit', $cabania->id) }}">

                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Cabaña">
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
      
    </div>
    @stop
    @section('css')
    @stop

    @section('js')

        <script src="{{ asset('admin1/cabanias/index.js') }}"></script>


    @stop
