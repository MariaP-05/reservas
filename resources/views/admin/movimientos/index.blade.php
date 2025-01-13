@extends('adminlte::page')

@section('title', 'Lista de Movimientos')

@section('content_header')
<h1>Movimientos</h1>
@stop

@section('content')
<div class="card">
    <a href="{{ route('admin.movimientos.create') }}" title="Crear Nuevo Movimiento"
        style="position:fixed;	width:60px;	height:60px; top:57px;	right:40px;
               background-color:#FFF;	color:#25d366;	border-radius:50px;	text-align:center;
            font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
        target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
        onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
        <i class="fa fa-plus" style="margin-top:16px"></i>
    </a>

    @include('admin.movimientos.partials.busqueda')

    <div class="cadr-body">
        <div class="form-group col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-6">
                        <label for="saldo">Saldo</label>
                        {{ Form::text('saldo', $saldo, ['saldo' => 'saldo', 'class' => 'form-control',  'readonly']) }}
                    </div>
                </div>
            </div>
            <table id="movimientos" class="table table-striped col-sm-12">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Id</th>
                        <th>Detalle</th>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Tipo de Movimiento</th>
                        <th>Hecho por</th>
                        <th>Categoría</th>
                        <th>Forma de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->id }}</td>
                        <td>{{ $movimiento->denominacion }}</td>
                        <td>{{ $movimiento->fecha}}</td>
                        <td>{{ $movimiento->importe }}</td>
                        <td>{{ $movimiento->tipo_movimiento }}</td>
                        <td>{{isset( $movimiento->User) ? $movimiento->User->name  : ''}}</td>
                        <td>{{isset( $movimiento->Categoria) ? $movimiento->Categoria->denominacion  : ''}}</td>
                        <td>{{ $movimiento->forma_pago }}</td>

                        <td>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <form method="post" action="{{ route('admin.movimientos.destroy', $movimiento->id) }}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            title="Eliminar Movimiento">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6 form-group">
                                    <form method="get" action="{{ route('admin.movimientos.edit', $movimiento->id) }}">

                                        <button type="submit" class="btn btn-outline-primary"
                                            title="Editar Movimiento">
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

    <script src="{{ asset('admin1/movimientos/index.js') }}"></script>

    @stop