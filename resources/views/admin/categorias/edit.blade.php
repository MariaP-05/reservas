@extends('adminlte::page')

@section('title', 'Categoría')


@section('content_header')
<h1>Categoría</h1>
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

                    @if(isset($categoria))
                    {{ Form::model($categoria,['route'=>['admin.categorias.update', $categoria->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.categorias.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($categoria->id))
                    <div class="row  col-md-12">
                        <div class="form-group col-md-6">
                            <label for="id">Id</label>
                            {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                        </div>
                    </div>
                    @endif
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="denominacion">Denominacion</label>
                            {{ Form::text('denominacion', null, array('id' => 'denominacion','class' => 'form-control','placeholder' => trans(''))) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                    </div>


                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-outline-danger" href="{{route('admin.categorias.index')}}">{{ trans('message.close') }}</a>
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