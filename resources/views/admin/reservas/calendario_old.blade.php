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
                <br>
            </div>
            <table id="reservas" class="table table-striped col-sm-12">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th colspan="1" style="border-left: solid 2px; border-right: solid 2px; border-color:#999;"> </th>
                        @foreach ($months as $month)
                        <th style="border-right: solid 2px; border-color:#999;" colspan="{{$month['dias']}}">
                            {{ ucfirst($month['mes']) }} 
                        </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="border-left: solid 2px; border-right: solid 2px; border-color:#999;" colspan="1"> Cabañas </th>
                        @foreach ($dias as $dia)
                            <th style="border-right: solid 2px; border-color:#999;" colspan="1">
                                 {{$dia->format('d') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $id_reserva = 0;
                    @endphp
                   
                    <tr>
                    @foreach ($cabanias as $cabania)
                        <td style="border-left: solid 2px; border-right: solid 2px; border-color:#999;" colspan="1">
                            {{ $cabania->denominacion }}
                        </td>
                        @foreach ($cab[$cabania->id] as $reserva)
                            @if(isset($reserva->id))
                                @if($reserva->id !== $id_reserva)
                                    @php
                                        $reserva->deno_cabania = isset($reserva->Cabania)
                                        ? $reserva->Cabania->denominacion : '';

                                        $reserva->nom_cliente = isset($reserva->Cliente)
                                        ? $reserva->Cliente->nombre : '';

                                        $reserva->deno_pago = isset($reserva->Forma_pago)
                                        ? $reserva->Forma_pago->denominacion : '';

                                        $reserva->deno_est_reserva = isset($reserva->Estado_reserva)
                                        ? $reserva->Estado_reserva->denominacion : '';
                                    @endphp
                                    <td style="border-right: solid 2px; border-color:#999; " colspan="{{(int)$reserva->span}}">
                                        <button type="button" class="btn btn-outline-success"
                                            title="Ver datos reserva" data-toggle="modal"
                                            data-target="#VerModal" data-whatever="{{ $reserva }}">
                                            <i class="fa fa-eye">
                                                {{isset($reserva->Cliente) ?  $reserva->Cliente->nombre : ''}}
                                            </i>
                                        </button>
                                    </td>
                                    @php
                                    $id_reserva = $reserva->id;
                                    @endphp
                                @endif
                            @else
                                <td style="border-right: solid 2px; border-color:#999; background-color:aquamarine" colspan="1"> 
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
    @stop