@extends('adminlte::page')

@section('title', 'Nuevo Cliente')


@section('content_header')
<h1>Clientes</h1>
<link href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" ></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet"/>
<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.css') }}"> 
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

                    @if(isset($cliente))
                    {{ Form::model($cliente,['route'=>['admin.clientes.update', $cliente->id],'method' => 'PUT', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @else
                    {{ Form::open(['route' => 'admin.clientes.store','method'=>'POST', 'role'=>'form', 'data-toggle'=>'validator']) }}
                    @endif

                    @if(isset($cliente->id))
                    <div class="row  col-md-12">
                    <div class="form-group col-md-6">
                        <label for="id">{{ trans('message.code') }}</label>
                        {{ Form::text('id', null, array('id' => 'id','class' => 'form-control','placeholder'=>"id", 'readonly')) }}
                    </div>
                    </div>
                    @endif
      
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="denominacion">{{trans('message.denomination')}}</label>
                            {{ Form::text('denominacion', null, array('id' => 'denominacion','class' => 'form-control','placeholder' => trans('message.denomination'))) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <div class="input-group date">
                                
                                {{ Form::text('fecha_nacimiento',isset($valor->fecha_nacimiento) ? $valor->fecha_nacimiento : null,  array('id' => 'fecha_nacimiento','class' => 'form-control','placeholder' => 'dd-mm-aaaa')) }}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>                        

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">
                            <label for="cuit">CUIT/CUIL</label>
                            {{ Form::text('cuit', null, array('id' => 'cuit','class' => 'form-control','placeholder' => 'CUIT / CUIL')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>   
                    </div> 

                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">                        
                            <label for="id_localidad">Localidad</label>
                            {{ Form::select('id_localidad', $localidades, null,  array('id' => 'id_localidad','class' => 'form-control select2')) }}
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                            <label for="direccion">Direccion</label>
                            {{ Form::text('direccion', null, array('id' => 'direccion','class' => 'form-control','placeholder' => 'Direccion')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                       
                    </div>      
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">                        
                            <label for="telefono">Telefono</label>
                            {{ Form::text('telefono', null, array('id' => 'telefono','class' => 'form-control','placeholder' => '0341353222')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 form-group has-feedback">
                        <label for="celular">Celular</label>
                            {{ Form::text('celular', null, array('id' => 'celular','class' => 'form-control','placeholder' => '0341353222')) }}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div> 
                    </div> 
                    <div class="row  col-md-12">
                        <div class="col-md-6 form-group has-feedback">                        
                            <label for="mail">{{trans('message.email')}}</label>
                                {{ Form::text('mail', null, array('id' => 'mail','class' => 'form-control','placeholder' => trans('message.email'),'pattern' => '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'))}}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                             </div>
                        <div class="col-md-6 form-group has-feedback">
                        <label for="mail_2">{{trans('message.email')}} Auxiliar</label>
                                {{ Form::text('mail_2', null, array('id' => 'mail_2','class' => 'form-control','placeholder' => trans('message.email'). ' Auxiliar','pattern' => '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$'))}}
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                             </div>
                    </div> 
                   

                    <div class="box-footer col-md-12 form-group pull-left ">
                        <a type="button" class="btn btn-danger" href="{{route('admin.clientes.index')}}">{{ trans('message.close') }}</a>
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
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



<script type="text/javascript"> 
    $(document).ready(function() {
       
        $('.select2').select2();  

       
        $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '<Ant',
      nextText: 'Sig>',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    
    $.datepicker.setDefaults($.datepicker.regional['es']);
     
      $("#fecha_nacimiento").datepicker(
        {
           todayBtn: "linked",
           language: 'es',
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'dd-mm-yy' 
       }
      );
      
         
    });

    </script>

 
@stop