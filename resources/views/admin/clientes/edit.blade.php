@extends('adminlte::page')

@section('title', 'Nuevo Cliente')


@section('content_header')

    <h1>Clientes</h1>

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

                        @if (isset($cliente))
                            {{ Form::model($cliente, ['route' => ['admin.clientes.update', $cliente->id], 'method' => 'PUT', 'role' => 'form', 'data-toggle' => 'validator', 'files' => true]) }}
                        @else
                            {{ Form::open(['route' => 'admin.clientes.store', 'method' => 'POST', 'role' => 'form', 'data-toggle' => 'validator', 'files' => true]) }}
                        @endif

                        @if (isset($cliente->id))
                            <div class="row  col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="id">{{ trans('message.code') }}</label>
                                    {{ Form::text('id', null, ['id' => 'id', 'class' => 'form-control', 'placeholder' => 'id', 'readonly']) }}
                                </div>
                            </div>
                        @endif

                        <div class="row  col-md-12">
                            <div class="col-md-6 form-group has-feedback">
                                <label for="nombre">Nombre</label>
                                {{ Form::text('nombre', null, ['id' => 'nombre', 'class' => 'form-control', 'placeholder' => trans('nombre')]) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 form-group has-feedback">
                                <label for="dni">DNI</label>
                                {{ Form::text('dni', null, ['id' => 'dni', 'class' => 'form-control', 'placeholder' => 'DNI']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="row  col-md-12">

                            <div class="col-md-6 form-group has-feedback">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <div class="input-group date">

                                    {{ Form::text('fecha_nacimiento', isset($cliente->fecha_nacimiento) ? $cliente->fecha_nacimiento : null, ['id' => 'fecha_nacimiento', 'class' => 'form-control', 'placeholder' => 'dd-mm-aaaa']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 form-group has-feedback">
                                <label for="mail">{{ trans('message.email') }}</label>
                                    {{ Form::text('mail', null, ['id' => 'mail', 'class' => 'form-control', 'placeholder' => trans('message.email'), 'pattern' => '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                        </div>

                        <div class="row  col-md-12">

                            <div class="col-md-6 form-group has-feedback">
                                <label for="telefono">Telefono</label>
                                {{ Form::text('telefono', null, ['id' => 'telefono', 'class' => 'form-control', 'placeholder' => '0341353222']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 form-group has-feedback">
                                <label for="telefono_aux">Telefono Auxiliar</label>
                                {{ Form::text('telefono_aux', null, ['id' => 'telefono_aux', 'class' => 'form-control', 'placeholder' => '0341353222']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            
                        </div>


                        <div class="row  col-md-12">

                            <div class="col-md-6 form-group has-feedback">
                                <label for="id_localidad">Localidad</label>
                                {{ Form::select('id_localidad', $localidades, null, ['id' => 'id_localidad', 'class' => 'form-control select2']) }}
                            </div>
                            <div class="col-md-6 form-group has-feedback">
                                <label for="direccion">Direccion</label>
                                {{ Form::text('direccion', null, ['id' => 'direccion', 'class' => 'form-control', 'placeholder' => 'Direccion']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        


                            <hr style="background-color:blue ; height: 2px"></hr>

                            <div class="info-card bg-secondary col-md-12" style="padding: 1em">
                                <label for="Archivo_Adjunto">Archivos Adjuntos</label>
                                <input type="file" class="form-control"
                                    title="Arrastre el Archivo o Haga click para seleccionar" id="Archivo_Adjunto[]"
                                    name="Archivo_Adjunto[]" multiple="">

                            </div>

                            <hr style="background-color:blue ; height: 2px"></hr>

                            <h3>Observaciones</h3>
                            <div class="row  col-md-12">
                                <div class="col-md-6 form-group has-feedback">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" id="observaciones" rows="1">{{isset($cliente) ? $cliente->observaciones : ''}}</textarea>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            
                            <br>
                            <div class="box-footer col-md-6 form-group pull-right ">
                                <a type="button" class="btn btn-outline-danger"
                                    href="{{ route('admin.clientes.index') }}">{{ trans('message.close') }}</a>
                                <button type="submit" class="btn btn-outline-primary">{{ trans('message.save') }}</button>
                            </div>
                            <br>

                            </table>


                            {{ Form::close() }}
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box -->
                    </div>


                </div>
            </div>
        @stop

        @section('css')

        @stop

        @section('js')
            <script src="{{ asset('admin1/clientes/edit.js') }}"></script>
        @stop
