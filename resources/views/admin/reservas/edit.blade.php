@extends('adminlte::page')

@section('title', 'Nueva Reserva')


@section('content_header')
<h1>Reservas</h1>

@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">

                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                 

                        @if (isset($reserva))
                            {{ Form::model($reserva, ['route' => ['admin.reservas.update', $reserva->id], 'method' => 'PUT', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @else
                            {{ Form::open(['route' => 'admin.reservas.store', 'method' => 'POST', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @endif

                        @if (isset($reserva->id))
                            <div class="row  col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="id">{{ trans('message.code') }}</label>
                                    {{ Form::text('id', null, ['id' => 'id', 'class' => 'form-control', 'placeholder' => 'id', 'readonly']) }}
                                </div>
                            </div>
                        @endif
 
                    <div class="row col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_cabania">Cabaña</label>
                            {{ Form::select('id_cabania', $cabanias, isset($id_cabania) ? $id_cabania : null, ['id' => 'id_cabania', 'class' => 'select2 form-control', 'data-url'=> route('admin.reservas.get')]) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>                        
                        <div class="col-md-6 form-group cliente-select has-feedback">
                            <a class="btn btn-xs btn-primary btn-add-cliente" title="Agregar Cliente" role="button"> <i class="fa fa-plus"></i></a>
 
                        
                            <label for="id_cliente">Cliente</label>
                            {{ Form::select('id_cliente', $clientes, null, ['id' => 'id_cliente', 'class' => 'form-control select2']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                    </div>

                    <div class="cliente_section">
                    <hr style="background-color:blue ; height: 1px"> </hr>
                        
                    
                    <div class="row col-md-12">
                    <h5 class=" box-title">
                            <a class="btn btn-xs btn-warning btn-delete-cliente" title="Seleccionar Cliente" role="button">
                                <i class="fa fa-minus"></i></a> Nuevo Cliente
                        </h5>
                        <div class="col-md-6 form-group">
                            <label for="nombre_cliente">Nombre</label>
                            {{ Form::text('nombre_cliente', null, array('id' => 'nombre_cliente','class' => 'form-control','placeholder'=>"Nombre del Cliente")) }}
                        </div>
                        <div class=" col-md-6 form-group">
                            <label for="telefono_cliente">Telefono</label>
                            {{ Form::text('telefono_cliente', null, array('id' => 'telefono_cliente','class' => 'form-control','placeholder'=>"Telefono del Cliente")) }}
                        </div>
                       
                    </div>
                    <hr style="background-color:blue ; height: 1px">
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="cantidad_personas">Cantidad de personas</label>
                            {{ Form::text('cantidad_personas', null, ['id' => 'cantidad_personas', 'class' => 'form-control']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_estado_reserva">Estado de reserva</label>
                            {{ Form::select('id_estado_reserva', $estado_reservas, null, ['id' => 'id_estado_reserva', 'class' => 'form-control select2']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                    </div>

                    <hr style="background-color:LightBlue ; height: 1px">
                    </hr>

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="fecha_desde">Fecha desde</label>
                            <div class="input-group date">
                                {{ Form::text('fecha_desde', isset($fecha) ? $fecha : null, ['id' => 'fecha_desde', 'class' => 'form-control', 'data-url'=> route('admin.reservas.get')]) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="fecha_hasta">Fecha hasta</label>
                            <div class="input-group date">
                                {{ Form::text('fecha_hasta', isset($fecha_hasta) ? $fecha_hasta : null, ['id' => 'fecha_hasta', 'class' => 'form-control', 'data-url'=> route('admin.reservas.get')]) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>

                    <hr style="background-color:LightBlue ; height: 1px">
                    </hr>
                    <div class="row  col-md-12">

                        <div class="col-md-6 form-group has-feedback">
                            <label for="hora_ingreso">Hora de ingreso</label>
                            {{ Form::time('hora_ingreso', null, ['id' => 'hora_ingreso', 'class' => 'form-control', 'placeholder' => 'hora']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>


                        <div class="col-md-6 form-group has-feedback">
                            <label for="hora_egreso">Hora de egreso</label>
                            {{ Form::time('hora_egreso', null, ['id' => 'hora_egreso', 'class' => 'form-control', 'placeholder' => 'hora']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                    </div>

                    <hr style="background-color:blue ; height: 3px">
                    </hr>
                    <div class="col-md-6 form-group has-feedback">
                            <label for="moneda">Moneda</label>
                            {{ Form::select('moneda',[ 'Pesos' => 'Pesos', 'Dolares' => 'Dolares'], null, array('id' => 'moneda','class' => 'form-control', 'data-url'=> route('admin.reservas.get')) )}}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-right">
                        <label for="importe_reserva">Importe Reserva</label>
                        {{ Form::text('importe_reserva',null , array('id' => 'importe_reserva','class' => 'form-control importe_reserva', 'readonly')) }}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-12">

                        <hr style="background-color:LightBlue ; height: 1px">
                        </hr>

                        <div class="row">
                            @if(isset($reserva))
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="descuento">Descuento $</label>
                                {{ Form::number('descuento',null , array('id' => 'descuento','class' => 'form-control descuento',  'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="descuento_porce">Descuento %</label>
                                {{ Form::number('descuento_porce',null , array('id' => 'descuento_porce','class' => 'form-control descuento_porce', 'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            @else
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="descuento">Descuento $</label>
                                {{ Form::number('descuento',0 , array('id' => 'descuento','class' => 'form-control descuento', 'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="descuento_porce">Descuento %</label>
                                {{ Form::number('descuento_porce',0 , array('id' => 'descuento_porce','class' => 'form-control descuento_porce',  'min'=>'0,00', 'step'=>'0,00', 'oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            @endif


                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-right">
                                <label for="total">TOTAL A PAGAR</label>
                                {{ Form::text('total',null , array('id' => 'total','class' => 'form-control total', 'readonly')) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                       
                            <div class="row">
                            @if(isset($reserva))
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="recargo">Recargo $</label>
                                {{ Form::number('recargo',null , array('id' => 'recargo','class' => 'form-control recargo',  'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="recargo_porce">Recargo %</label>
                                {{ Form::number('recargo_porce',null , array('id' => 'recargo_porce','class' => 'form-control recargo_porce', 'min'=>'0', 'step'=>'0','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            @else
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="recargo">Recargo $</label>
                                {{ Form::number('recargo',0 , array('id' => 'recargo','class' => 'form-control recargo', 'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-left">
                                <label for="recargo_porce">Recargo %</label>
                                {{ Form::number('recargo_porce',0 , array('id' => 'recargo_porce','class' => 'form-control recargo_porce',  'min'=>'0', 'step'=>'0', 'oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            @endif
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-right">
                                <label for="motivos_recargos">Motivo del Recargo</label>
                                {{ Form::text('motivos_recargos', null, ['id' => 'motivos_recargos', 'class' => 'form-control']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            </div>
                        <div class="row">
                        @if(isset($reserva))
                            <div class="col-md-4 form-group has-feedback">
                                <label for="senia">Seña</label>
                                {{ Form::text('senia', null, ['id' => 'senia', 'class' => 'form-control senia',  'min'=>'0,00', 'step'=>'0,00', 'oninput'=>"validity.valid||(value='');"]) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        @else
                        <div class="col-md-4 form-group has-feedback">
                                <label for="senia">Seña</label>
                                {{ Form::text('senia', 0, ['id' => 'senia', 'class' => 'form-control senia',  'min'=>'0,00', 'step'=>'0,00', 'oninput'=>"validity.valid||(value='');"]) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        @endif
                            <div class="col-lg-4 col-md-4 col-xs-6 form-group pull-right">
                                <label for="total_deuda">TOTAL ADEUDADO</label>
                                {{ Form::text('total_deuda',null , array('id' => 'total_deuda','class' => 'form-control total_deuda', 'readonly')) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="background-color:LightBlue ; height: 1px">
                </hr>

                <div class="row col-md-12">
                    <div class="col-md-6 form-group has-feedback">
                        <label for="id_forma_pago">Forma de Pago</label>
                        {{ Form::select('id_forma_pago', $formas_pago, null, ['id' => 'id_forma_pago', 'class' => 'form-control select2']) }}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-6 form-group has-feedback">
                        <label for="ctabancaria">Cuenta Bancaria</label>
                        {{ Form::text('ctabancaria', null, ['id' => 'ctabancaria', 'class' => 'form-control']) }}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>

                <hr style="background-color:blue ; height: 3px">
                </hr>
                <div class="row col-md-12">
                    <div class="col-sm-12  form-group has-feedback">
                        <label for="observaciones">Observaciones </label>
                        <textarea class="form-control" name="observaciones" id="observaciones" rows="3">{{ isset($reserva) ? $reserva->observaciones : '' }}</textarea>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>




                <div class="box-footer col-md-12 form-group pull-left ">
                    <a type="button" class="btn btn-outline-danger"
                        href="{{ route('admin.reservas.index') }}">{{ trans('message.close') }}</a>
                    <button type="submit" class="btn btn-outline-primary">{{ trans('message.save') }}</button>
                </div>
                {{ Form::close() }}
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
    </div>


</div>
</div>
@stop

@section('css')
@stop


@section('js')
<script src="{{ asset('admin1/reservas/edit.js') }}"></script>
<script src="{{ asset('admin1/reservas/edit_descuento.js') }}"></script>

@stop