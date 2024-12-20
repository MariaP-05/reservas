@extends('adminlte::page')

@section('title', 'Nueva Reserva')


@section('content_header')
<h1>Reservas</h1>
   
@stop

@section('content')
<div class="card">
    <div class="cadr-body">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    @if(isset($reserva))
                    {{ Form::model($reserva,['route'=>['admin.reservas.update', $reserva->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.reservas.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($reserva->id))
                    <div class="row  col-md-12">
                    <div class="form-group col-md-6">
                        <label for="id">{{ trans('message.code') }}</label>
                        {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                    </div>
                    </div>
                    @endif
                   
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_cabania">Cabaña</label>
                            {{ Form::select('id_cabania', $cabanias, null,  array('id' => 'id_cabania','class' => 'select2 form-control ')) }}
                              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_cliente">Cliente</label>
                                {{ Form::select('id_cliente', $clientes, null,  array('id' => 'id_cliente','class' => 'form-control select2')) }}
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        
                    </div>                   

                    <div class="row  col-md-12">                       
                        <div class="col-md-6 form-group has-feedback">
                            <label for="cantidad_personas">Cantidad de personas</label>
                            {{ Form::text('cantidad_personas', null, array('id' => 'cantidad_personas','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        @if(isset($reserva->id))
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_estado_reserva">Estado de reserva</label>
                            {{ Form::select('id_estado_reserva', $estado_reserva, null,  array('id' => 'id_estado_reserva','class' => 'form-control select2')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        @endif
                    </div>      


                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                                <label for="fecha_desde">Fecha desde</label>
                                <div class="input-group date">
                                    {{ Form::text('fecha_desde',isset($valor->fecha_desde) ? $valor->fecha_desde : null,  array('id' => 'fecha_desde','class' => 'form-control')) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                
                        </div>
                            <div class="col-md-6 form-group has-feedback">
                                <label for="fecha_hasta">Fecha hasta</label>
                                <div class="input-group date">
                                    {{ Form::text('fecha_hasta',isset($valor->fecha_hasta) ? $valor->fecha_hasta : null,  array('id' => 'fecha_hasta','class' => 'form-control')) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                    </div>

                    <div class="row  col-md-12">
                        
                        <div class="col-md-6 form-group has-feedback">
                            <label for="hora_ingreso">Horario de ingreso</label>
                            <div class="row">
                                <div class="col-md-3 form-group has-feedback">

                                    {{ Form::select('hora_ingreso', $horas, null, ['id' => 'hora_ingreso', 'class' => 'form-control']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label for="hora_egreso">Horario de egreso</label>

                                    <div class="row">
                                        <div class="col-md-3 form-group has-feedback">
        
                                            {{ Form::select('hora_egreso', $horas, null, ['id' => 'hora_egreso', 'class' => 'form-control']) }}
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="senia">Seña</label>
                            {{ Form::text('senia', null, array('id' => 'senia','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="descuento">Descuento</label>
                            {{ Form::text('descuento', null, array('id' => 'descuento','class' => 'form-control')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div> 

                    <div class="row col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_forma_pago">Forma de Pago</label>
                                {{ Form::select('id_forma_pago', $formas_pago, null,  array('id' => 'id_forma_pago','class' => 'form-control select2')) }}
                                  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="col-sm-12  form-group has-feedback">
                                <label for="observacion">Observaciones </label>
                                <textarea class="form-control" name="observacion" id="observacion" rows="3">{{isset($reserva) ? $reserva->observacion : ''}}</textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                    </div> 

                
                    
                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-danger" href="{{route('admin.reservas.index')}}">{{ trans('message.close') }}</a>
                        <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
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
 

@stop