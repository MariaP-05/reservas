@extends('adminlte::page')

@section('title', 'Nuevo Productor')


@section('content_header')
<h1>Nuevo Productor</h1>
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

                    @if(isset($productor))
                    {{ Form::model($productor,['route'=>['admin.productores.update', $productor->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.productores.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($productor->id))
                    <div class="row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="id">Id</label>
                            {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                        </div>
                    </div>
                    @endif
                    <div class="row col-md-12">
                    <div class="col-md-6 form-group has-feedback">
                            <label for="codigo">Codigo</label>
                            {{ Form::text('codigo', null, array('id' => 'codigo','class' => 'form-control','placeholder' => 'Codigo')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="col-md-6 form-group has-feedback">
                            <label for="nombre">Nombre</label>
                            {{ Form::text('nombre', null, array('id' => 'nombre','class' => 'form-control','placeholder' => 'Nombre')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="row col-md-12">
                    <div class="col-md-6 form-group has-feedback">
                            <label for="matricula">Matrícula</label>
                            {{ Form::text('matricula', null, array('id' => 'matricula','class' => 'form-control','placeholder' => 'Matricula')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
      
                </div>


                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-danger" href="{{route('admin.productores.index')}}">{{ trans('message.close') }}</a>
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


@stop