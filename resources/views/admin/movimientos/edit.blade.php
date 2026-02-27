@extends('adminlte::page')

@section('title', 'Nuevo Movimiento')


@section('content_header')
<h1>Movimiento</h1>

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

                    @if (isset($movimiento))
                    {{ Form::model($movimiento, ['route' => ['admin.movimientos.update', $movimiento->id], 'method' => 'PUT', 'role' => 'form', 'data-toggle' => 'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.movimientos.store', 'method' => 'POST', 'role' => 'form', 'data-toggle' => 'validator']) }}
                    @endif

                    @if (isset($movimiento->id))
                    <div class="row  col-md-12">
                        <div class="form-group col-md-6">
                            <label for="id">{{ trans('message.code') }}</label>
                            {{ Form::text('id', null, ['id' => 'id', 'class' => 'form-control', 'placeholder' => 'id', 'readonly']) }}
                        </div>
                    </div>
                   
                    @endif

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="denominacion">Detalle</label>
                            {{ Form::text('denominacion', null, array('id' => 'denominacion','class' => 'form-control','placeholder' => trans(''))) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="fecha">Fecha</label>
                            <div class="input-group date">
                                {{ Form::text('fecha', isset($valor->fecha) ? $valor->fecha : null, ['id' => 'fecha', 'class' => 'form-control']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="importe">Importe</label>
                            {{ Form::number('importe', null, ['id' => 'importe', 'class' => 'form-control','step'=>'any']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
  @if (!isset($movimiento->id))
                   
                     <div class="col-md-6 form-group has-feedback">
                            <label for="cuotas">Cuotas</label>
                            {{ Form::number('cuotas', 1, ['id' => 'cuotas', 'class' => 'form-control','step'=>'any']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    @endif
                    
                    </div>
                     <div class="row  col-md-12">
                        
    <div class="col-md-6 form-group has-feedback">
                            <label for="tipo_movimiento">Tipo de Movimiento</label>
                            {{ Form::select('tipo_movimiento',[ 'Egreso' => 'Egreso', 'Ingreso' => 'Ingreso'], null, array('id' => 'tipo_movimiento','class' => 'form-control') )}}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="moneda">Moneda</label>
                            {{ Form::select('moneda',[ 'Pesos' => 'Pesos', 'Dolares' => 'Dolares'], null, array('id' => 'moneda','class' => 'form-control') )}}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_categoria">Categoria</label>
                            {{ Form::select('id_categoria', $categorias, null, ['id' => 'id_categoria', 'class' => 'form-control select2']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 form-group has-feedback">
                            <label for="id_usuario">Hecho por:</label>
                            {{ Form::select('id_usuario', $usuarios, null, ['id' => 'id_usuario', 'class' => 'form-control select2']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>


                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="forma_pago">Forma de pago</label>
                            {{ Form::text('forma_pago', null, ['id' => 'forma_pago', 'class' => 'form-control']) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="estado">Estado</label>
                            {{ Form::select('estado',[ 'Pendiente' => 'Pendiente', 'Saldado' => 'Saldado'], null, array('id' => 'estado','class' => 'form-control') )}}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="row  col-md-12">
                        <div class="col-sm-12  form-group has-feedback">
                            <label for="observaciones">Observaciones </label>
                            <textarea class="form-control" name="observaciones" id="observaciones" rows="3">{{ isset($movimiento) ? $movimiento->observaciones : '' }}</textarea>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-outline-danger"
                            href="{{ route('admin.movimientos.index') }}">{{ trans('message.close') }}</a>
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
<script src="{{ asset('admin1/movimientos/edit.js') }}"></script>


@stop