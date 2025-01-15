@extends('adminlte::page')

@section('title', 'Nueva Tarea')


@section('content_header')
    <h1>Tarea</h1>

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

                        @if (isset($tarea))
                            {{ Form::model($tarea, ['route' => ['admin.tareas.update', $tarea->id], 'method' => 'PUT', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @else
                            {{ Form::open(['route' => 'admin.tareas.store', 'method' => 'POST', 'role' => 'form', 'data-toggle' => 'validator']) }}
                        @endif

                        @if (isset($tarea->id))
                            <div class="row  col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="id">{{ trans('message.code') }}</label>
                                    {{ Form::text('id', null, ['id' => 'id', 'class' => 'form-control', 'placeholder' => 'id', 'readonly']) }}
                                </div>
                            </div>
                        @endif

                        <div class="row  col-md-12">
                            <div class="col-md-6 form-group has-feedback">
                                <label for="denominacion">Denominación</label>
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

                        <div class="row  col-md-12">
                            <div class="col-md-6 form-group has-feedback">
                                <label for="descripcion">Descripción</label>
                                {{ Form::text('descripcion', null, ['id' => 'descripcion', 'class' => 'form-control']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                           
                            <div class="col-md-6 form-group has-feedback">
                                <label for="prioridad">Prioridad</label>
                                {{ Form::select('prioridad',[ 'Alta' => 'Alta', 'Media' => 'Media', 'Baja' => 'Baja'], null, array('id' => 'prioridad','class' => 'form-control') )}}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>      
                            </div>
                           
                        </div>


                        <div class="row  col-md-12">
                            
                                <div class="col-md-6 form-group has-feedback">
                                    <label for="id_estado_tarea">Estado</label>
                                    {{ Form::select('id_estado_tarea', $estados_tarea, null, ['id' => 'id_estado_tarea', 'class' => 'form-control select2']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>

                                <div class="col-md-6 form-group has-feedback">
                                    <label for="id_usuario">Asignada para:</label>
                                    {{ Form::select('id_usuario', $usuarios, null, ['id' => 'id_usuario', 'class' => 'form-control select2']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            
                        </div>

                        
                        <div class="row  col-md-12">

                            <div class="col-sm-12  form-group has-feedback">
                                <label for="observaciones">Observaciones </label>
                                <textarea class="form-control" name="observaciones" id="observaciones" rows="3">{{ isset($tarea) ? $tarea->observaciones : '' }}</textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                        

                        <div class="box-footer col-md-12 form-group pull-left ">
                            <a type="button" class="btn btn-outline-danger"
                                href="{{ route('admin.tareas.index') }}">{{ trans('message.close') }}</a>
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
    <script src="{{ asset('admin1/tareas/edit.js') }}"></script>


@stop
