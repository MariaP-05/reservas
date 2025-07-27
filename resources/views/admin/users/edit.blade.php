
@extends('adminlte::page')
@if(Auth::user()->id_profesional >= 1 && Auth::user()->id !== $user->id )
@section('content')
<div class="card">
 
<h3 class="box-title bg-red">No tiene Permiso para acceder a esta seccion</h3>
</div> 
@stop
@else
@if(!isset(Auth::user()->Profesional))
@if(isset($user->id))
@section('title', 'Editar Usuario')
@else
@section('title', 'Nuevo Usuario')
@endif
@else
@section('title', 'Cambiar Contraseña')
@endif



@section('content_header')
@if(!isset(Auth::user()->Profesional))
<h1>Usuarios</h1>
@else
<h1>Cambiar Contraseña</h1>
@endif
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

                    @if(isset($user))
                    {{ Form::model($user,['route'=>['admin.users.update', $user->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.users.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif
                    @if(!isset(Auth::user()->Profesional))
                    @if(isset($user->id))
                    <div class="row  col-md-12">
                    <div class="form-group col-md-6">
                        <label for="id">{{ trans('message.code') }}</label>
                        {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                    </div>
                    </div>
                    @endif
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="name">{{trans('message.name')}}</label>
                            {{ Form::text('name', null, array('id' => 'name','class' => 'form-control','placeholder' => trans('message.name'), 'required')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="email">{{trans('message.email')}}</label>
                            {{ Form::text('email', null, array('id' => 'email','class' => 'form-control','placeholder' => trans('message.email'), 'required')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>                   
                    @endif
                    <div class="row   col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="password">{{trans('message.password')}}</label>
                            {{ Form::text('password', null, array('id' => 'password','class' => 'form-control' , 'required')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                         
                    </div>
                    

                    <div class="box-footer col-md-6 form-group pull-right ">
                        <a type="button" class="btn btn-outline-danger" href="{{route('admin.users.index')}}">{{ trans('message.close') }}</a>
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


@endif