@extends('adminlte::page')

@if(isset($precio))
@section('title', 'Editar Precio')
@else
@section('title', 'Nuevo Precio')
@endif

@section('content_header')
<h1>Precios</h1>
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

                    @if(isset($precio))
                    {{ Form::model($precio,['route'=>['admin.precios.update', $precio->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.precios.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($precio->id))
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
                            {{ Form::select('id_cabania', $cabanias, null, ['id' => 'id_cabania', 'class' => 'form-control select2']) }}
                        </div>

                        <div class="col-md-6 form-group has-feedback">
                            <label for="fecha_desde">Fecha Desde</label>
                            <div class="input-group date">

                                {{ Form::text('fecha_desde', isset($precio->fecha_desde) ? $precio->fecha_desde : null, ['id' => 'fecha_desde', 'class' => 'form-control', 'placeholder' => 'dd-mm-aaaa']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="valor">Valor</label>
                            {{ Form::number('valor', null, array('id' =>'valor', 'class' => 'form-control', 'step'=>'any')) }}

                        </div>
                    </div>
                    <div class="box-footer col-md-6 form-group pull-right ">
                        <a type="button" class="btn btn-outline-danger" href="{{route('admin.precios.index')}}">{{ trans('message.close') }}</a>
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
<script src="{{ asset('admin1/precios/edit.js') }}"></script>
@stop