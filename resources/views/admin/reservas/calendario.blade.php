@extends('adminlte::page')

@section('title', 'Lista de Reservas')

@section('content_header')
    <h1>Calendario de Noches Reservadas por Cabaña</h1>
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

    @include('admin.reservas.partials.busqueda')

        <div class="card-body" >
            <div class="form-group col-sm-12">
                <table id="reservas" class="table col-sm-12" style="width: 100%;">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th style="width:5%; background:lightgray;">Día\Cabaña</th>
                            @foreach ($cabanias as $cabania)
                                <th style="width:19%; background:lightgray;">{{ $cabania->denominacion }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dias as $dia)
                            <tr>
                                <th style="border-right: solid 2px; border-color:lightgray; background:lightgray; text-align:center;" rowspan="1">
                                    {{ $dia->format('d/m') }} </th>
                                @foreach ($cabanias as $cabania)
                                    @if (isset($cab[$cabania->id][$dia->format('md')]->Cliente))
                                    @if($cab[$cabania->id][$dia->format('md')]->span > 0)
                                      @php
                                        $cab[$cabania->id][$dia->format('md')]->deno_cabania = isset($cab[$cabania->id][$dia->format('md')]->Cabania)
                                        ? $cab[$cabania->id][$dia->format('md')]->Cabania->denominacion : '';

                                        $cab[$cabania->id][$dia->format('md')]->nom_cliente = isset($cab[$cabania->id][$dia->format('md')]->Cliente)
                                        ? $cab[$cabania->id][$dia->format('md')]->Cliente->nombre : '';

                                        $cab[$cabania->id][$dia->format('md')]->deno_pago = isset($cab[$cabania->id][$dia->format('md')]->Forma_pago)
                                        ? $cab[$cabania->id][$dia->format('md')]->Forma_pago->denominacion : '';

                                        $cab[$cabania->id][$dia->format('md')]->deno_est_reserva = isset($cab[$cabania->id][$dia->format('md')]->Estado_reserva)
                                        ? $cab[$cabania->id][$dia->format('md')]->Estado_reserva->denominacion : '';
                                    @endphp
                                        <td style="border-right: solid 2px; border-color:lightgray; background-color:rgba(229, 250, 212, 1); vertical-align:middle;" rowspan="{{ $cab[$cabania->id][$dia->format('md')]->span }}">
                                            <button type="button" class="btn btn-outline-success" title="Ver datos reserva"
                                                data-toggle="modal" data-target="#VerModal" style="width:100%"
                                                data-whatever="{{ $cab[$cabania->id][$dia->format('md')] }}">
                                                <i class="fa fa-eye">
                                                    {{ isset($cab[$cabania->id][$dia->format('md')]->Cliente) ? $cab[$cabania->id][$dia->format('md')]->Cliente->nombre   : '' }}
                                                </i>
                                            </button>
                                        </td>
                                        @endif
                                    @else
                                        <td style="border-right: solid 2px; border-color:lightgray;">
                                            <a href="{{ route('admin.reservas.create_fecha', ['id_cabania' => $cabania->id, 'fecha' => $dia->format('d-m-Y'), 'fecha_hasta' => $dia->format('d-m-Y')]) }}" title="Crear Nueva Reserva" class="btn btn-outline-success">
                                                <i class="fa fa-plus success"  ></i>
                                            </a>
                                        </td>
                                    @endif
                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('admin.reservas.partials.ver')
        </div>
    </div>
@stop

@section('css')
 
 
@stop

@section('js')

    <script src="{{ asset('admin1/reservas/calendario.js') }}"></script>
    <script src="{{ asset('admin1/movimientos/index.js') }}"></script>
@stop
