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
            <table id="reservas" class="table table-striped col-sm-12">
                <thead class="bg-secondary text-white">
                    <tr>
                    <th colspan="1" style = "border-right: solid 2px; border-color:#999;"></th>
                        @foreach ($months as $month)
                        <th style = "border-right: solid 2px; border-color:#999;" colspan="{{$span[$t]}}">{{ucfirst($month) }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th style = "border-right: solid 2px; border-color:#999;" colspan="1">Cabanias </th>
                        @foreach ($dias as $dia)
                        <th style = "border-right: solid 2px; border-color:#999;" colspan="2">{{$dia->format('d') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $id_reserva = 0;
                    @endphp
                    @foreach ($cabanias as $cabania)
                    <tr>
                        <td style = "border-right: solid 2px; border-color:#999;" colspan="1">{{ $cabania->denominacion }}</td>
                        @foreach ($cab[$cabania->id] as $reserva)
                            @if(isset($reserva->id))
                                @if($reserva->id !== $id_reserva)                                    
                                    <td style = "border-right: solid 2px; border-color:#999;" colspan="{{$reserva->span}}">{{isset($reserva->Cliente) ? $reserva->Cliente->nombre : ''}} </td>
                                    @php
                                        $id_reserva = $reserva->id;
                                    @endphp
                                @endif
                            @else
                                @if(isset($reserva->span))
                                <td style = "border-right: solid 2px; border-color:#999;" colspan="{{$reserva->span}}">s </td>
                                @else
                                    <td style = "border-right: solid 2px; border-color:#999;" colspan="2">t </td>
                                @endif
                            @endif
                        @endforeach
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

    @stop