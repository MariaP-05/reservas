@extends('adminlte::page')

@section('title', 'Nueva Cabaña')


@section('content_header')
    <h1>Nueva Cabaña</h1>
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
                                {{ Form::text('denominacion', null, ['id' => 'denominacion', 'class' => 'form-control', 'placeholder' => trans('Denominación'), 'required']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 form-group has-feedback">
                                <label for="capacidad">Capacidad</label>
                                {{ Form::text('capacidad', null, ['id' => 'capacidad', 'class' => 'form-control', 'placeholder' => 'Capacidad']) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                        </div>
                         <div class="row  col-md-12">
 <div class="col-md-6 form-group has-feedback">
                            <label for="color">Color</label>
                            <div class="input-group">
                                <input id="color" name="color" type="color" value=
                                {{ isset($cabania->color) ? $cabania->color : "#ff0000" }} />
                            </div>
                        </div>
 </div>

                        <hr style="background-color:blue ; height: 2px">
                        </hr>
                        <h3>Caracteristicas</h3>
                        <div class="caracteristicas-section col-md-12">
                            <div class="row nueva_caracteristica col-md-12">

                                <div class="col-md-6 form-group has-feedback">
                                    <label for="id_caracteristica">Caracteristica</label>
                                    {{ Form::select('id_caracteristica[]', $caracteristicas, null, ['id' => 'id_caracteristica', 'class' => 'form-control select2']) }}
                                </div>

                                <div class="col-md-6 form-group has-feedback">
                                    <label for="cantidad">Cantidad</label>
                                    {{ Form::number('cantidad[]', null, ['id' => 'cantidad', 'class' => 'form-control cantidad']) }}
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6 form-group">

                            <a class="btn btn-xs btn-info btn-add-caracteristica" role="button">
                                <i class="fa fa-plus"> </i>
                            </a>
                        </div>
                        <hr style="background-color:aliceblue ; height: 2px">
                        </hr>
                        @if (isset($cabania->Caracteristicas))
                            @if (count($cabania->Caracteristicas) > 0)
                            @endif

                            <table id="caracteristicas" class="table table-striped col-12">
                                <thead class="bg-secondary text-white">

                                    <tr>
                                        <th>Caracteristica</th>
                                        <th>Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @foreach ($cabania->Caracteristicas as $caracteristica)
                                    <tr>
                                        <td class="col-md-6 form-group">
                                            {{ isset($caracteristica->Caracteristica) ? $caracteristica->Caracteristica->denominacion : '' }}
                                        </td>
                                        <td class="col-md-6 form-group">
                                            {{ $caracteristica->cantidad }}
                                        </td>
                                        <td>
                                            <div class="col-md-3 form-group">
                                                <a href="{{ route('admin.cabanias.delete_caract', ['id' => $caracteristica->id]) }}"
                                                    class="btn btn-xs btn-outline-danger float-right" title="Eliminar"
                                                    role="button">
                                                    <i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        @endif

                        </table>
                        <hr style="background-color:blue ; height: 2px">
                        </hr>

                        <div class="row  col-md-12">
                            <div class="col-md-6  form-group has-feedback">
                                <label for="observaciones">Observaciones </label>
                                <textarea class="form-control" name="observaciones" id="observaciones" rows="3">{{ isset($cabania) ? $cabania->observaciones : '' }}</textarea>
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
    <script src="{{ asset('admin1/cabanias/edit.js') }}"></script>
@stop
