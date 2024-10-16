@extends('adminlte::page')

@section('title', 'Lista de Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <div class="card">
        <a href="{{ route('admin.clientes.create') }}" title="Crear Nuevo Cliente"
            style="position:fixed;	width:60px;	height:60px; top:57px;	right:40px;
                   background-color:#FFF;	color:#25d366;	border-radius:50px;	
                   text-align:center; font-size:30px;	box-shadow: 2px 2px 3px #999; z-index:100;"
            target="_blank" onMouseOver="this.style.color='#FFF'; this.style.background = '#25d366'"
            onMouseOut="this.style.color='#25d366'; this.style.background = '#fff'">
            <i class="fa fa-plus" style="margin-top:16px"></i>
        </a>
        <div class="cadr-body">
            <div class="form-group col-sm-12">
                <div class="row">
                    <br>
                </div>
                <table id="clientes" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Denominacion</th>
                            <th>CUIT/CUIL</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Celular</th>
                            <th>{{ trans('message.email') }}</th>
                            <th>Localidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->denominacion }}</td>
                                <td>{{ $cliente->cuit }}</td>
                                <td>{{ $cliente->fecha_nacimiento }}</td>
                                <td>{{ $cliente->celular }}</td>
                                <td>{{ $cliente->mail }}</td>
                                <td>{{ isset($cliente->Localidad) ? $cliente->Localidad->denominacion : '' }}</td>

                                <td>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
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
                                        <div class="col-md-6 form-group">
                                            <form method="get" action="{{ route('admin.clientes.edit', $cliente->id) }}">

                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Cliente">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            @php
                                                $cliente->deno_localidad = $cliente->Localidad->denominacion;
                                            @endphp
                                            <button type="button" class="btn btn-outline-warning"
                                                onMouseOver="this.style.color='#FFF'"
                                                onMouseOut="this.style.color= '#fa7101'" data-toggle="modal"
                                                data-target="#VerModal" data-whatever="{{ $cliente }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('admin.clientes.partials.ver')
        </div>

    @stop
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    @stop

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#clientes').DataTable({
                        "language": {
                            "search": "Buscar",
                            "lengthMenu": "Mostrar _MENU_ registros por pagina",
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "zeroRecords": "No se encontraron resultados",
                            "emptyTable": "Ningún dato disponible en esta tabla",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "infoPostFix": "",
                            "url": "",
                            "infoThousands": ",",
                            "loadingRecords": "Cargando...",
                            "aria": {
                                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sortDescending": ": Activar para ordenar la columna de manera descendente"
                            }



                        },
                        responsive: true,
                        autowith: false,
                        order: [
                            [0, 'desc']
                        ]
                    }


                );


            });
        </script>




    @stop
