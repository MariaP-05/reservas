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
                        </div>

                        <div class="row  col-md-12">
                            <div class="col-md-6 form-group has-feedback">
                                <label for="descripcion">Descripción</label>
                                {{ Form::text('descripcion', null, ['id' => 'descripcion', 'class' => 'form-control']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                           
                            <div class="col-md-6 form-group has-feedback">
                                <label for="prioridad">Prioridad</label>
                                {{ Form::select('prioridad',[ '' => 'Seleccione' , 'Alta' => 'Alta', 'Media' => 'Media', 'Baja' => 'Baja'], null, array('id' => 'prioridad','class' => 'form-control select2') )}}
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

                        <hr style="background-color:blue ; height: 3px"></hr>
                        
                        <h3>Observaciones</h3>
                        <div class="row  col-md-12">
                            <div class="col-sm-12  form-group has-feedback">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control" name="observaciones" id="observaciones" rows="1"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        

                        <div class="box-footer col-md-6 form-group pull-right ">
                            <a type="button" class="btn btn-outline-danger"
                                href="{{ route('admin.tareas.index') }}">{{ trans('message.close') }}</a>
                            <button type="submit" class="btn btn-outline-primary">{{ trans('message.save') }}</button>
                        </div>


                        <hr style="background-color:blue ; height: 3px"></hr>


                     @if (isset($tarea->Historial_obs))
                       @if (count($tarea->Historial_obs) > 0)
                        <h3>Historial de Observaciones</h3>
                        
                        <table id="historial_obs" class="table table-striped col-12">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>Observación</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($tarea->Historial_obs as $historial_obs)
                                <tr>

                                    <td class="col-md-6 form-group"
                                        style="text-align:center">
                                        {{ $historial_obs->observaciones }}</td>
                                    <td class="col-md-2 form-group">
                                        {{ isset($historial_obs->User) ? $historial_obs->User->name : '' }}
                                    </td>
                                    <td class="col-md-3 form-group">{{ $historial_obs->fecha }}</td>
                                    <td>
                                        <div class="col-md-3 form-group">
                                            <a href="{{route('admin.tareas.delete_ho',['id'=>$historial_obs->id ])}}"
                                                class="btn btn-xs btn-outline-danger float-right" title="Eliminar" role="button">
                                                <i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                       @endif
                     @endif
                   



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
