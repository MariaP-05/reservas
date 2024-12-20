@extends('adminlte::page')

@section('title', 'Lista de Reservas')

@section('content_header')
    <h1>Reservas</h1>
@stop

@section('content')
    <div class="card">
        <a href="{{ route('admin.reservas.create') }}" title="Crear Nueva Reserva"
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
                <table id="datatable1" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Cabaña</th>
                            <th>Cliente</th>
                            <th>Cantidad de personas</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Hora de ingreso</th>
                            <th>Hora de egreso</th>
                            <th>Seña</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th>Forma de pago</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->id }}</td>
                                <td>{{ isset($reserva->Cabania) ? $reserva->Cabania->denominacion : '' }}</td>
                                <td>{{ isset($reserva->Cliente) ? $reserva->Cliente->nombre : '' }}</td>
                                <td>{{ $reserva->cantidad_personas }}</td>   

                                
                                <td>{{ $reserva->fecha_desde }}</td>
                                <td>{{ $reserva->fecha_hasta }}</td>
                                <td>{{ $reserva->hora_ingreso }}</td>
                                <td>{{ $reserva->hora_egreso }}</td>

                                <td>{{ $reserva->senia }}</td>
                                <td>{{ $reserva->descuento }}</td>
                                <td>{{ isset($reserva->Estado_reserva) ? $reserva->Estado_reserva->denominacion : '' }}</td>
                                <td>{{ isset($reserva->Forma_pago) ? $reserva->Forma_pago->denominacion : '' }}</td>
                                <td>{{ $reserva->observaciones }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <form method="post" action="{{ route('admin.reservas.destroy', $reserva->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar Reserva">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <form method="get" action="{{ route('admin.reservas.edit', $reserva->id) }}">

                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Reserva">
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
    
    <script src="{{ asset('admin1/reservas/index.js') }}"></script>
 
    @stop
