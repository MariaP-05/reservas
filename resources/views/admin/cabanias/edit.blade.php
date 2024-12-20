@extends('adminlte::page')

@section('title', 'Nueva Cabaña')


@section('content_header')
    <h1>Nueva Cabaña</h1>
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

                        @if (isset($cabania))
                            {{ Form::model($cabania, ['route' => ['admin.cabanias.update', $cabania->id], 'method' => 'PUT', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @else
                            {{ Form::open(['route' => 'admin.cabanias.store', 'method' => 'POST', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @endif

                        @if (isset($cabania->id))
                            <div class="row  col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="id">Id</label>
                                    {{ Form::text('id', null, ['id' => 'id', 'class' => 'form-control', 'placeholder' => 'id', 'readonly']) }}
                                </div>
                            </div>
                        @endif
                        <div class="row  col-md-12">
                                <div class="col-md-6 form-group has-feedback">
                                    <label for="denominacion">Denominación</label>
                                    {{ Form::text('denominacion', null, array('id' => 'denominacion','class' => 'form-control','placeholder' => trans('Denominación'), 'required')) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="col-md-6 form-group has-feedback">
                                    <label for="capacidad">Capacidad</label>
                                    {{ Form::text('capacidad', null, ['id' => 'capacidad', 'class' => 'form-control', 'placeholder' => 'Capacidad']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                        
                            </div>

                        <div class="row  col-md-12">
                            <div class="col-md-6  form-group has-feedback">
                                <label for="observacion">Observaciones </label>
                                <textarea class="form-control" name="observacion" id="observacion" rows="3">{{ isset($institucion) ? $institucion->observacion : '' }}</textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                        </div>


                        <div class="box-footer col-md-6 form-group pull-right ">
                            <a type="button" class="btn btn-outline-danger"
                                href="{{ route('admin.cabanias.index') }}">{{ trans('message.close') }}</a>
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


@stop
