@extends('adminlte::page')

@section('title', 'Cotizaciones Monedas Extranjeras')


@section('content_header')
<h1>Cotizaciones Monedas Extranjeras </h1>
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

                    @if(isset($cotizaciones_monedas))
                    {{ Form::model($cotizaciones_monedas,['route'=>['admin.cotizaciones_monedas.update', $cotizaciones_monedas->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.cotizaciones_monedas.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($cotizaciones_monedas->id))
                    <div class="row  col-md-12">
                        <div class="form-group col-md-6">
                            <label for="id">Id</label>
                            {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                        </div>
                    </div>
                    @endif
                     <div class="col-xs-6 form-group has-feedback">
                            <label for="fecha">Fecha Desde</label>
                            <div class="input-group date">
                                {{ Form::text('fecha', isset($fecha) ? $fecha : null, ['id' => 'fecha', 'class' => 'form-control']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                             </div>
<div class="col-xs-6 form-group">
                                <label for="usd">Cotización USD</label>
                                {{ Form::number('usd',null , array('id' => 'usd','class' => 'form-control usd',  'min'=>'0,00', 'step'=>'0,00','oninput'=>"validity.valid||(value='');")) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-outline-danger" href="{{route('admin.cotizaciones_monedas.index')}}">{{ trans('message.close') }}</a>
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

<script src="{{ asset('admin1/cotizaciones_monedas/edit.js') }}"></script>

@stop