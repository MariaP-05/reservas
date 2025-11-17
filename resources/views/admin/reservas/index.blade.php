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

        <div class="card-body">
            <div class="form-group col-sm-12">
                <div class="row">
                    @include('flash-message')
                    <br>
                </div>
                <table id="reservas" class="table table-striped col-sm-12">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>Id</th>
                            <th>Fecha reserva</th>
                            <th>Cabaña</th>
                            <th>Cliente</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Forma de Pago</th>
                            <th>Estado</th>
                            <th>Importe</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->id }}</td>
                                <td>{{ $reserva->fecha_reserva }}</td>
                                <td>{{ isset($reserva->Cabania) ? $reserva->Cabania->denominacion : '' }}</td>
                                <td>{{ isset($reserva->Cliente) ? $reserva->Cliente->nombre : '' }}
                                    @if (isset($reserva->Cliente))
                                        <a href="https://api.whatsapp.com/send?phone=549{{ $reserva->Cliente->telefono }}"
                                            title="Enviar Mensaje">
                                            <img src="{{ asset('img/whatsapp.png') }}"
                                                style=" width:20px;	height:20px;  " />
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $reserva->fecha_desde }}</td>
                                <td>{{ $reserva->fecha_hasta }}</td>
                                  <td>{{ isset($reserva->Forma_pago) ? $reserva->Forma_pago->denominacion : '' }}</td>
                                <td>{{ isset($reserva->Estado_reserva) ? $reserva->Estado_reserva->denominacion : '' }}</td>
                                @if ($reserva->moneda == 'Pesos')
                                    <td>{{ '$' . number_format($reserva->valor, 0, ',', '.') }}</td>
                                @else
                                    <td>{{ 'U$S' . number_format($reserva->valor, 0, ',', '.') }}</td>
                                @endif
                                <td>
                                    <div class="row col-md-12">
                                        <div class="col-md-3 form-group">
                                            <form method="post"
                                                action="{{ route('admin.reservas.destroy', $reserva->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar Reserva">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <form method="get" action="{{ route('admin.reservas.edit', $reserva->id) }}">

                                                <button type="submit" class="btn btn-outline-primary"
                                                    title="Editar Reserva">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </form>
                                        </div>



                                        <div class="col-md-3 form-group">
                                            @php
                                                $reserva->deno_cabania = isset($reserva->Cabania)
                                                    ? $reserva->Cabania->denominacion
                                                    : '';

                                                $reserva->nom_cliente = isset($reserva->Cliente)
                                                    ? $reserva->Cliente->nombre
                                                    : '';

                                                      $reserva->razon_social = isset($reserva->Cliente)
                                                    ? $reserva->Cliente->razon_social
                                                    : '';

                                                      $reserva->cuit = isset($reserva->Cliente)
                                                    ? $reserva->Cliente->cuit
                                                    : '';

                                                $reserva->deno_pago = isset($reserva->Forma_pago)
                                                    ? $reserva->Forma_pago->denominacion
                                                    : '';

                                                $reserva->deno_est_reserva = isset($reserva->Estado_reserva)
                                                    ? $reserva->Estado_reserva->denominacion
                                                    : '';
                                            @endphp
                                            <button type="button" class="btn btn-outline-warning" title="Ver datos reserva"
                                                onMouseOver="this.style.color='#FFF'"
                                                onMouseOut="this.style.color= '#fa7101'" data-toggle="modal"
                                                data-target="#VerModal" data-whatever="{{ $reserva }}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <form method="get"
                                                action="{{ route('admin.movimientos.impactar_pago', $reserva->id) }}">

                                                <button type="submit" class="btn btn-outline-success"
                                                    {{ $reserva->isPagada() ? '' : 'disabled' }}
                                                    title="Impactar Pago de Reserva">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <form method="get"
                                                action="{{ route('admin.reservas.export', [$reserva->id, 'pdf']) }}">

                                                <button type="submit" class="btn btn-outline-secondary"
                                                    title="Imprimir Comprobante">
                                                    <i class="fa fa-file"></i>
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
            @include('admin.reservas.partials.ver')
        </div>
    @stop

    @section('css')

    @stop

    @section('js')

        <script src="{{ asset('admin1/reservas/index.js') }}"></script>

    @stop
