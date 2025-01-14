@extends('adminlte::page')

@section('title', 'Lista de Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <div class="card">
        <a href="{{ route('admin.clientes.create') }}" title="Crear Nuevo Cliente"
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
@include('flash-message')
            <br>
                </div>

                <table id="clientes" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Nombre y Apellido</th>
                            <th>DNI</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Teléfono Aux</th>
                            <th>Mail</th>
                            
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->dni }}</td>
                                <td>{{ $cliente->fecha_nacimiento }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->telefono_aux }}</td>
                                <td>{{ $cliente->mail }}</td>
                                
                                <td>
                                    <div class="row col-sm-md-lg-12">
                                        <div class="col-md-3 form-group">
                                            <form method="get"
                                                action="{{ route('admin.clientes.edit', $cliente->id) }}">

                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Cliente">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <div class="col-md-3 form-group">
                                            <form method="post"
                                                action="{{ route('admin.clientes.destroy', $cliente->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar Cliente">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    
                                        <div class="col-md-3 form-group">
                                            @php
                                                $cliente->deno_localidad = isset($cliente->Localidad)
                                                    ? $cliente->Localidad->denominacion
                                                    : '';
                                            @endphp
                                            <button type="button" class="btn btn-outline-warning"
                                                title="Ver datos cliente" onMouseOver="this.style.color='#FFF'"
                                                onMouseOut="this.style.color= '#fa7101'" data-toggle="modal"
                                                data-target="#VerModal" data-whatever="{{ $cliente }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <a href="{{ route('admin.clientes.archivos', $cliente->id) }}"
                                                class="btn btn-outline-success" title="Archivos Cliente"
                                                 role="button"
                                                target="_blank" style="width:44px;	height:39px; top:40px;	right:20px;">
                                                <i class="fa fa-folder-open"><?php echo \App\Models\Cliente::countFiles($cliente->id); ?> </i>
                                            </a>
                                        </div>

                                                                          
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        @include('admin.clientes.partials.ver')
    </div>

@stop


@section('css')

@stop
@section('js')

    <script src="{{ asset('admin1/clientes/index.js') }}"></script>
@stop
